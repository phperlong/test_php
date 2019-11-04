<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/20
 * Time: 3:00
 */

class App
{
    //自身的实例
    public static $instance;

    //访问的模块
    public $urlModelus = "";
    //绑定的数组
    public static $bindArr = [];
    //控制器数组
    public static $classArr = [];

    private function __construct()
    {
        $this->autoLoadRegister();
        $this->bind("Request");
        $this->urlModelus = self::$bindArr['Request']->urlModules;
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function autoLoadRegister():void
    {
        spl_autoload_register([$this,"loaderClass"]);
        spl_autoload_register([$this,"loaderModel"]);
    }

    public function loaderClass(string $class):void
    {
        $file = MODULES_PATH.$this->urlModelus."\\controllers\\".$class.".php";
        if (!file_exists($file))
            throw new MyException(MyError::NFCLASS['msg'].":".$class,MyError::NFCLASS['code']);
        require $file;
    }

    public function loaderModel(string $model):void
    {
        $file = MODULES_PATH.$this->urlModelus."\\models\\".$model.".php";
        if (!file_exists($file))
            throw new MyException(MyError::NFCLASS['msg'].":".$model,MyError::NFCLASS['code']);
        require $file;
    }

    public function make(string $class = "",array $parameters = array())
    {
        if ("" === $class)
            return "";
        $refClass = new ReflectionClass($class);

        // 查看是否可以实例化
        if (!$refClass->isInstantiable())
            throw new MyException($class.MyError::NONEW['msg'],MyError::NONEW['code']);
        // 查看是否用构造函数
        $rel_method = $refClass->getConstructor();
        // 依赖关系数组
        $actual_parameters = [];
        if (is_null($rel_method)){
            self::$classArr[$class] = new $class();
        }else{
            $dependencies = $rel_method->getParameters();
            // 处理，把传入的索引数组变成关联数组， 键为函数参数的名字
            foreach ($parameters as $key => $value)
            {
                if (is_numeric($key))
                {
                    // 删除索引数组， 只留下关联数组
                    unset($parameters[$key]);

                    // 用参数的名字做为键
                    $parameters[$dependencies[$key]->name] = $value;
                }
            }

            if (!empty($dependencies))
            {
                foreach ($dependencies as $dependenci)
                {
                    // 获取对象名字，如果不是对象返回 null

                    $class_name = $dependenci->getClass();
                    // 获取变量的名字
                    $var_name = $dependenci->getName();
                    // 如果是对象， 则递归new

                    if (array_key_exists($var_name, $parameters))
                    {
                        $actual_parameters[] = $parameters[$var_name];
                    }
                    elseif (is_null($class_name))
                    {
                        // null 则不是对象，看有没有默认值， 如果没有就要抛出异常
                        if (!$dependenci->isDefaultValueAvailable())
                        {
                            throw new Exception($var_name . ' 参数没有默认值');
                        }
                        $actual_parameters[] = $dependenci->getDefaultValue();
                    }
                    else
                    {
                        $actual_parameters[] = self::make($class_name->getName());
                    }
                }
            }
        }
        return $refClass->newInstanceArgs($actual_parameters);
    }

    public function bind(string $class):void
    {
        if (!isset($this->bindArr[$class]))
           self::$bindArr[$class] = $this->make($class);
    }

    public function run()
    {
        $request = self::$bindArr['Request'];
        if (!isset(self::$classArr[$request->urlClass]))
        {
            $class =  $this->make($request->urlClass);
            self::$classArr[$request->urlClass] = $class;
        }
        call_user_func_array(array(self::$classArr[$request->urlClass],$request->urlMethond),array());
    }

    public static function instance():object
    {
        if (!self::$instance)
            self::$instance = new self();
        return self::$instance;
    }


}