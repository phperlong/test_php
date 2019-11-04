<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/10/18
 * Time: 6:48
 */
class XArray implements ArrayAccess{

    private $container = array();
    public function __construct(int $size = 0,int $value = 0) {
        if ($size > 0) {
            $this->container = array_fill(0, $size, $value);
        }
    }

    public function offsetSet($offset, $value):void
    {
        if(is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset):object
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function offsetExists($offset):bool
    {
        return isset($this->container[$offset]);
    }
}