<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    private $client;

    public function setUp(){
        $this->client = static::createClient();
        $fixtures = array('ApiBundle\DataFixtures\ORM\LoadUrlData');
        $this->loadFixtures($fixtures);
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testRedirect()
    {
        $crawler = $this->client->request('GET', '/tiny.cj');
        $response = $this->client->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('https://www.youtube.com/', $response->headers->get('location'));

    }

    public function testIncorrectIndex()
    {
        $crawler = $this->client->request('GET', '/blarg');

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Url target not found', $crawler->filter('#content h1')->text());
    }

    public function testRedirectDesktopAction() {

        $this->client->request('GET', '/tiny.3k', array(), array(), array('HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246'));
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();
        $location = $response->headers->get('location');

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('tiny.3k');

        $this->assertEquals(1, $updatedUrl->getDesktopRedirects());
        $this->assertEquals($location, $updatedUrl->getTargetDesktopUrl());
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testRedirectMobileAction() {
        $this->client->request('GET', '/tiny.3k', array(), array(), array('HTTP_USER_AGENT' => 'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'));
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();
        $location = $response->headers->get('location');

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('tiny.3k');

        $this->assertEquals(1, $updatedUrl->getMobileRedirects());
        $this->assertEquals($location, $updatedUrl->getTargetMobileUrl());  
        $this->assertEquals(302, $response->getStatusCode());      
    }

    public function testRedirectTabletAction() {
        $this->client->request('GET', '/tiny.3k', array(), array(), array('HTTP_USER_AGENT' => 'Mozilla/5.0 (Tablet; rv:26.0) Gecko/26.0 Firefox/26.0'));
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();
        $location = $response->headers->get('location');

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('tiny.3k');

        $this->assertEquals(1, $updatedUrl->getTabletRedirects());
        $this->assertEquals($location, $updatedUrl->getTargetTabletUrl());        
        $this->assertEquals(302, $response->getStatusCode());
    }
}