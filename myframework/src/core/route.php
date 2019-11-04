<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/18
 * Time: 3:49
 */

class Route
{
    public static $routeArr = ["get"=>array(),"post"=>array()];

    public static function __callStatic(string $name = "",array $arguments = []):void
    {
        // TODO: Implement __call() method.
        $realUrlArr = explode("/",$arguments[1]);
        if (empty(implode(",",$realUrlArr)))
            throw new MyException(MyError::ERROUTE['msg'],MyError::ERROUTE['code']);
        $routeArr = array(
            "module"=>$realUrlArr[1],
            "class"=>$realUrlArr[2],
            "methond"=>$realUrlArr[3],
        );
         implode($routeArr);
        self::$routeArr[$name][$arguments[0]] = $routeArr;
    }

    public static function loderRoute():array
    {
        return self::$routeArr;
    }


}