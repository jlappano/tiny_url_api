<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testRedirect()
    {
        $client = static::createClient();
        $fixtures = array('ApiBundle\DataFixtures\ORM\LoadUrlData');
        $this->loadFixtures($fixtures);
        $crawler = $client->request('GET', '/tiny.cj');
        $response = $client->getResponse();
        var_dump($client->getResponse());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('https://www.youtube.com/', $response->headers->get('location'));

    }
}