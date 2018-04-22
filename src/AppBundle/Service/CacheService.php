<?php

namespace AppBundle\Service;

use Predis\Client;
use Predis\Connection\ConnectionException;

/**
* Here you have to implement a CacheService with the operations below.
* It should contain a failover, which means that if you cannot retrieve
* data you have to hit the Database.
**/
class CacheService
{
    protected $redis;
    protected $isOn;

    public function __construct($host, $port, $prefix)
    {
        $this->startRedis($host, $port, $prefix);
    }

    private function startRedis($host, $port, $prefix)
    {
        try {
            $this->redis = new Client([
                'host' => $host, 
                'port' => $port
            ]);
            
            $this->redis->connect();

            $this->isOn = true;
        } catch(ConnectionException $e) {
            $this->isOn = false;
        }
    }

    public function get($key)
    {
        if (!$this->isOn)
            return null;

        return $this->redis->get($key);
    }

    public function set($key, $value)
    {
        if ($this->isOn) {
            $this->redis->set($key, $value);
        }
    }

    public function del($key)
    {
        if ($this->isOn) {
            $this->redis->del($key);
        }
    }
}
