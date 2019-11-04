<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/19
 * Time: 2:12
 */

class ConfigLoader
{
    public static $instance = [];
    public function __construct()
    {
        $config_arr = require_once CONFIG_PATH;
        self::$instance = $config_arr;
    }

    public function loader(string $config):string
    {
        //判断是否多级查找
        if (strstr($config,"."))
        {
            $config_level_parma = explode(".",$config);
            $key = end($config_arr);
            $config_arr = self::$instance;
            $config_value = $this->loader_config_arr($config_arr,$config_level_parma,$key);
        }else{
            if (!isset(self::$instance[$config]))
                throw new MyException(Error::NFCONFIG['msg'],MyError::NFCONFIG['code']);
            $config_value = self::$instance[$config];
        }
        return $config_value;
    }

    public function loader_config_arr(array $config_arr,array $config_level_parma,$key)
    {
        if (!isset($config_arr[$config_level_parma[0]]))
            throw new MyException(MyError::NFCONFIG['msg'],MyError::NFCONFIG['code']);

        if ($config_level_parma[0] != $key)
        {
            if (!is_array($config_arr[$config_level_parma[0]]))
                throw new MyException(Error::NFCONFIG['msg'],Error::NFCONFIG['code']);
            $config_level_parma = array_shift($config_level_parma);
            $this->loader_config_arr($config_arr[$config_level_parma[0]],$config_level_parma,$key);
        }else{
            return $config_arr[$config_level_parma[0]];
        }

    }
}