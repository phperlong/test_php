<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/19
 * Time: 2:09
 */

class MyException extends \Exception
{
    public function __construct(string $message="",int $code = 0)
    {
        // 确保所有变量都被正确赋值
        parent::__construct($message, $code);
        if ($code > 0)
        {
            $this->getDetail();
        }
    }

    public function getDetail():void
    {
//        if (APP_DEBUG === true){
            $this->getDetails();
//        }else{
//            echo "出错了!";
//        }
    }
    public function getDetails():string
    {
        echo '<h1>出现异常了！</h1>';
        $msg = '<p>错误内容：<b>' . $this->getMessage() . '</b></p>';
        $msg .= '<p>异常抛出位置：<b>' . $this->getFile() . '</b>，第<b>' . $this->getLine() . '</b>行</p>';
        $msg .= '<p>异常追踪信息：<b>' . $this->getTraceAsString() . '</b></p>';
        echo $msg;
        echo '<hr>';
        echo '<pre>';
        print_r($this->getTrace()) ;
        echo '</pre>';
        exit;
    }
}