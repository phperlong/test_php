<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/15
 * Time: 13:36
 */


class AutoLoader
{
    public static $instance = [];

    public function __construct()
    {

    }
    public static function register($directory = ""):void
    {
        $directory = $directory?:SRC_CORE_PATH;
        if(is_dir($directory)) {
            //返回一个 Directory 类实例
            $mydir = dir($directory);
            //从目录句柄中读取条目
            while($file = $mydir->read()) {
                if ($file == "." || $file == "..")
                    continue;
                if(is_dir("$directory\\$file") && $file != "." && $file != "..") {
                    //递归读取目录
                    self::register("$directory\\$file");
                }else{
                    //引入文件
                    self::loadFile("$directory\\$file");
                }
            }
            // 释放目录句柄
            $mydir->close();
        }
    }

    public static function loadFile($file)
    {
        if (!file_exists($file))
            throw new MyException(MyError::NFFILE['msg'],MyError::NFFILE['code']);
        require $file;
    }

    public static function run()
    {

    }

}