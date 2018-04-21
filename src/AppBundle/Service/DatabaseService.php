<?php

namespace AppBundle\Service;

use \MongoDB\Driver\Manager;
use \MongoDB\Driver\Query;
use \MongoDB\Driver\Command;
use \MongoDB\Driver\BulkWrite;
use \MongoDB;

class DatabaseService
{
    protected $database;
    protected $manager;

    public function __construct($host, $port, $database)
    {
        $manager = new Manager("mongodb://$host:$port/$database");

        $this->setManager($manager);
        $this->setDatabase($database);
    }

    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function executeQuery($collection, $filters = [], $options = [])
    {
        $query = new Query($filters);

        return $this->manager->executeQuery($this->database . '.' . $collection, $query);
    }

    public function bulkWrite($collection, $data)
    {
        $bulkWrite = new BulkWrite;
        
        foreach ($data as $item) {
            $bulkWrite->insert($item);
        }
        
        return $this->manager->executeBulkWrite($this->database . '.' . $collection, $bulkWrite);
    }

    public function drop($collection)
    {
        $drop = new Command(["drop" => $collection]);

        return $this->manager->executeCommand($this->database, $drop);
    }

}
