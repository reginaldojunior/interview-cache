<?php

namespace AppBundle\Service;

use Predis\Client;

/**
* Here you have to implement a CacheService with the operations below.
* It should contain a failover, which means that if you cannot retrieve
* data you have to hit the Database.
**/
class CacheService
{
    protected $redis;

    public function __construct($host, $port, $prefix)
    {
        $this->redis = new Client([
            'host' => $host, 
            'port' => $port
        ]);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function set($key, $value)
    {
        $this->redis->set($key, $value);
    }

    public function del($key)
    {
        $this->redis->del($key);
    }
}
