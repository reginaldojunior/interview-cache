<?php

namespace AppBundle\Service;

use \MongoDB\Driver\Manager as MongoClient;
use \MongoDB;

class DatabaseService
{
    protected $database;

    public function __construct($host, $port, $database)
    {
        $mongoClient = new MongoClient("mongodb://$host:$port/$database");

        $this->setDatabase(
            $mongoClient->selectDB($database)
        );
    }

    public function setDatabase(MongoDB $database)
    {
        $this->database = $database;
    }

    public function getDatabase()
    {
        return $this->database;
    }
}
