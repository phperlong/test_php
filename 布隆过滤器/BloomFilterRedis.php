<?php
/**
 * Created by PhpStorm.
 * User: feilong
 * Date: 2019/7/13
 * Time: 20:02
 */
/**
 * 使用redis实现的布隆过滤器
 */
abstract class BloomFilterRedis
{
    /**
     * 需要使用一个方法来定义bucket的名字
     */
    protected $bucket;

    protected $hashFunction;

    public function __construct($config, $id)
    {
        if (!$this->bucket || !$this->hashFunction) {
            throw new Exception("需要定义bucket和hashFunction", 1);
        }
        $this->Hash = new BloomFilterHash;
        $this->Redis = new YourRedis; //假设这里你已经连接好了
    }

    /**
     * 添加到集合中
     */
    public function add($string)
    {
        $pipe = $this->Redis->multi();
        foreach ($this->hashFunction as $function) {
            $hash = $this->Hash->$function($string);
            $pipe->setBit($this->bucket, $hash, 1);
        }
        return $pipe->exec();
    }

    /**
     * 查询是否存在, 存在的一定会存在, 不存在有一定几率会误判
     */
    public function exists($string)
    {
        $pipe = $this->Redis->multi();
        $len = strlen($string);
        foreach ($this->hashFunction as $function) {
            $hash = $this->Hash->$function($string, $len);
            $pipe = $pipe->getBit($this->bucket, $hash);
        }
        $res = $pipe->exec();
        foreach ($res as $bit) {
            if ($bit == 0) {
                return false;
            }
        }
        return true;
    }

}