<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CacheServiceTest extends WebTestCase
{

    protected $serviceCache;

    public function setUp()
    {
        $this->client = static::createClient();
        
        $this->serviceCache = new \AppBundle\Service\CacheService(
            $this->client->getKernel()->getContainer()->getParameter('cache_host'),
            $this->client->getKernel()->getContainer()->getParameter('cache_port'),
            $this->client->getKernel()->getContainer()->getParameter('cache_prefix')
        );

        $this->serviceCacheFail = new \AppBundle\Service\CacheService(
            '127.0.0.1',
            '',
            ''
        );
    }

    public function testGetNullKey()
    {
        $this->assertEquals(null, $this->serviceCache->get('test'));
    }

    public function testSetKeyAndGet()
    {
        $value = time();
        
        $this->serviceCache->set('test', $value);

        $this->assertEquals($value, $this->serviceCache->get('test'));
    }

    public function testDelKey()
    {
        $this->serviceCache->del('test');

        $this->assertEquals(null, $this->serviceCache->get('test'));
    }

    public function testSetKeyAndGetCacheFail()
    {
        $value = time();
        
        $this->serviceCacheFail->set('test', $value);

        $this->assertEquals(null, $this->serviceCacheFail->get('test'));
    }

}