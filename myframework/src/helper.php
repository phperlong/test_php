<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/18
 * Time: 3:44
 */
if(!function_exists("file_include"))
{
    function file_include($directory) {
        if(is_dir($directory)) {
            //返回一个 Directory 类实例
            $mydir = dir($directory);
            //从目录句柄中读取条目
            while($file = $mydir->read()) {

                if ($file == "." || $file == "..")
                    continue;
                if(is_dir("$directory\\$file") && $file != "." && $file != "..") {
                    //递归读取目录
                    tree("$directory/$file");
                }else{
                    //否则引入文件
                        require $directory."\\".$file;
                }
            }
            // 释放目录句柄
            $mydir->close();
        } elseif (is_file($directory)){
            require $directory;
        }else{

        }
    }
}
