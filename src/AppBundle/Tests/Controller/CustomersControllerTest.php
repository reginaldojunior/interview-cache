<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomersControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testCreateCustomers()
    {
        $customers = [
            ['name' => 'Leandro', 'age' => 26],
            ['name' => 'Marcelo', 'age' => 30],
            ['name' => 'Alex', 'age' => 18],
        ];
        
        $customers = json_encode($customers);

        $this->client->request('POST', '/customers/', [], [], ['CONTENT_TYPE' => 'application/json'], $customers);

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $response = json_decode($this->client->getResponse()->getContent(), 1);

        $this->assertEquals(['status' => 'Customers successfully created'], $response);
    }

    public function testGetCustomers()
    {
        $this->client->request('GET', '/customers/');

        $response = json_decode($this->client->getResponse()->getContent(), 1);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('name', $response[0]);
        $this->assertArrayHasKey('age', $response[0]);
    }

    public function testDeleteCustomers()
    {
        $this->client->request('DELETE', '/customers/');

        $response = json_decode($this->client->getResponse()->getContent(), 1);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(['status' => 'Customers successfully deleted'], $response);
    }

    public function testGetEmptyCustomers()
    {
        $this->client->request('GET', '/customers/');

        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertEmpty($response);
    }

}
