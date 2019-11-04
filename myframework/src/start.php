<?php

/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/14
 * Time: 10:45
 */
//框架目录
define("SRC_PATH",__DIR__);
//框架核心目录
define("SRC_CORE_PATH",__DIR__."\\core\\");
//模块目录
define("MODULES_PATH",__DIR__."\\..\\modules\\");;
//缓存文件目录
define("RUNTIME_PATH",__DIR__."..\\runtime\\");
//配置文件位置
define("CONFIG_PATH",MODULES_PATH."config.php");
//路由文件位置
define("ROUTE_PATH",MODULES_PATH."route.php");

require "auto_loader.php";

AutoLoader::register();

AutoLoader::run();

App::instance()->run();



