<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DatabaseServiceTest extends WebTestCase
{

    protected $serviceDatabase;

    public function setUp()
    {
        $this->client = static::createClient();
        
        $this->serviceDatabase = new \AppBundle\Service\DatabaseService(
            $this->client->getKernel()->getContainer()->getParameter('database_host'),
            $this->client->getKernel()->getContainer()->getParameter('database_port'),
            $this->client->getKernel()->getContainer()->getParameter('database_name')
        );
    }

    public function testGetDatabase()
    {
        $this->assertEquals('easytaxi-symfony-cache-test', $this->serviceDatabase->getDatabase());
    }

    public function testExecuteQueryReturnEmpty()
    {
        $customers = $this->serviceDatabase->executeQuery('customers');
        $customers = iterator_to_array($customers);

        $this->assertEmpty($customers);
    }

    public function testBulkWrite()
    {
        $data = [
            [
                'name' => 'Valdomiro Santiago',
                'age' => 57
            ],
            [
                'name' => 'Edir Macedo',
                'age' => 89
            ]
        ];

        $bulkWrite = $this->serviceDatabase->bulkWrite('customers', $data);

        $this->assertEquals(2, $bulkWrite->getInsertedCount());
    }

    public function testExecuteQueryReturnNotEmpty()
    {
        $customers = $this->serviceDatabase->executeQuery('customers');
        $customers = iterator_to_array($customers);

        $this->assertNotEmpty($customers);   
    }

    public function testDropCollection()
    {
        $this->serviceDatabase->drop('customers');

        $customers = $this->serviceDatabase->executeQuery('customers');
        $customers = iterator_to_array($customers);

        $this->assertEmpty($customers);
    }

}