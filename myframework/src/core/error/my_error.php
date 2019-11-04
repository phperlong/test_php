<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/19
 * Time: 3:18
 */

class MyError
{
    const NFCONFIG = array(
        "msg"=>"未找到定义的配置",
        "code"=>"000001",
    );

    const NFROUTE = array(
        "msg"=>"未找到定义的路由",
        "code"=>"000002",
    );
    const NFMODEULES = array(
        "msg"=>"未找到定义的模块",
        "code"=>"000003",
    );
    const NFCLASS = array(
        "msg"=>"模块下未找到定义的类",
        "code"=>"000004",
    );
    const NFMETHOND = array(
        "msg"=>"类下未找到定义的方法",
        "code"=>"000004",
    );
    const NFFILE = array(
        "msg"=>"类下未找到文件",
        "code"=>"000006",
    );
    const NONEW = array(
        "msg"=>"这个类不能被实例化",
        "code"=>"000005",
    );
    const ERROUTE = array(
        "msg"=>"路由书写错误",
        "code"=>"000007",
    );
}