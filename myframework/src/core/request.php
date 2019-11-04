<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/31
 * Time: 3:13
 */

class Request
{
    //访问的方式
    public $methond = "";
    //访问的地址
    public $url = "";
    //访问的路由
    public $route = "";
    //访问的模块
    public $urlModules = "";
    //访问的控制器
    public $urlClass = "";
    //访问的方法
    public $urlMethond = "";
    //路由数组
    public static $routeArr = [];

    public function __construct()
    {
        self::routeLoader();
        $this->getUrl();
    }

    public static function routeLoader():array
    {
        if (!isset(self::$coreArr['Route']))
        {
            require_once ROUTE_PATH;
            self::$routeArr = Route::loderRoute();
        }
        return self::$routeArr;
    }
    public function getUrl():void
    {
        //将url分割
        $get_url = $_SERVER['REQUEST_URI'];
        $url_parms = parse_url($get_url);
        $this->route = $url_parms['path'];
        $this->methond = strtolower($_SERVER['REQUEST_METHOD']);
        if (!isset(self::$routeArr[$this->methond][$this->route]))
            throw new MyException(MyError::NFROUTE['msg'].":".$this->route,MyError::NFROUTE['code']);
        //路由配置的模块 类 方法
        $this->urlModules = self::$routeArr[$this->methond][$this->route]['module'];
        $this->urlClass = ucfirst(self::$routeArr[$this->methond][$this->route]['class']);
        $this->urlMethond = self::$routeArr[$this->methond][$this->route]['methond'];
    }

}