<?php

namespace Tests\ApiBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase {

    private $client;
    private $expectedTinyUrl;
    private $expectedUpdatedUrl;

    public function setUp(){
        $this->client = static::createClient();
        $this->expectedTinyUrl = '{"tiny url":"http:\/\/tiny.38"}';
        $fixtures = array('ApiBundle\DataFixtures\ORM\LoadUrlData');
        $this->loadFixtures($fixtures);
    }

    protected function assertJsonResponse($response, $statusCode = 200) {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    //4. User should be able to retrieve a list of all existing shortened URLs, including time since creation and target URLs (each with number of redirects)
    public function testListAction() {
        $route =  $this->getUrl('api_url_list~json');

        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $firstEntry = json_decode($content, true)[0];

        $this->assertJsonResponse($response, 200);
        $this->assertArrayHasKey('tinyUrl', $firstEntry);
        $this->assertArrayHasKey('timeStamp', $firstEntry);
        $this->assertArrayHasKey('desktopRedirects', $firstEntry);
        $this->assertArrayHasKey('tabletRedirects', $firstEntry);
        $this->assertArrayHasKey('mobileRedirects', $firstEntry);
    }

    //1. User should be able to submit any URL and get a standardized, shortened URL back
    public function testCreateAction() {
        $route =  $this->getUrl('api_url_create~json');
        $requestContent = json_encode(array('url' => 'http://my_very_long_testing_url_why_does_it_evenhavetobethinslonghelpme177798827272727'));

        $this->client->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $requestContent);
        $response = $this->client->getResponse();
        $content = $response->getContent();
        
        $this->assertJsonResponse($response, 200);
        $this->assertEquals($this->expectedTinyUrl, $content);
    }

    //1.a User should get an error if url is not supplied
    public function testCreateActionError() {
        $route =  $this->getUrl('api_url_create~json');
        $requestContent = json_encode(array('wrong_payload' => 'is_wrong'));

        $this->client->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $requestContent);
        $response = $this->client->getResponse();
        
        $this->assertJsonResponse($response, 400);
    }

    //2. User should be able to configure a shortened URL to redirect to different targets based on the device type (mobile, tablet, desktop) of the user navigating to the shortened URL
    public function testUpdateAction() {
        $route =  $this->getUrl('api_url_update~json');
        $requestContent = json_encode(array(
            'tiny_url' => 'http://tiny.9m',
            'tablet_target' => 'http://tablet/testTarget',
            'mobile_target' => 'http://mobile/testTarget',
            'desktop_target' => 'http://desktop/testTarget'
        ));

        $this->client->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $requestContent);
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('http://tiny.9m');
        $this->assertEquals('http://desktop/testTarget', $updatedUrl->getTargetDesktopUrl());
        $this->assertEquals('http://mobile/testTarget', $updatedUrl->getTargetMobileUrl());
        $this->assertEquals('http://tablet/testTarget', $updatedUrl->getTargetTabletUrl());
    }

    //2.a User should get an error if parameters are wrong
    public function testUpdateActionError() {
        $route =  $this->getUrl('api_url_update~json');
        $requestContent = json_encode(array('wrong_payload' => 'is_wrong'));

        $this->client->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $requestContent);
        $response = $this->client->getResponse();
        
        $this->assertJsonResponse($response, 400);
    }

    //3. Navigating to a shortened URL should redirect to the appropriate target URL
    public function testRedirectDefaultAction() {
        $route =  $this->getUrl('api_url_redirect~json');
        $requestContent = json_encode(array(
            'tiny_url' => 'http://tiny.cj',
        ));

        $this->client->request('GET', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $requestContent);
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();
        
        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('http://tiny.cj');
        $this->assertEquals($targetUrl, $updatedUrl->getTargetDesktopUrl());
        $this->assertJsonResponse($response, 302);
    }

    public function testRedirectDesktopAction() {
        $route =  $this->getUrl('api_url_redirect~json');
        $requestContent = json_encode(array(
            'tiny_url' => 'http://tiny.cN',
        ));

        $this->client->request('GET', $route, array(), array(), array('CONTENT_TYPE' => 'application/json', 'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246'), $requestContent);
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('http://tiny.cN');

        $this->assertEquals(1, $updatedUrl->getDesktopRedirects());
        $this->assertEquals($targetUrl, $updatedUrl->getTargetDesktopUrl());
        $this->assertJsonResponse($response, 302);
    }

    public function testRedirectMobileAction() {
        $route =  $this->getUrl('api_url_redirect~json');
        $requestContent = json_encode(array(
            'tiny_url' => 'http://tiny.cN',
        ));

        $this->client->request('GET', $route, array(), array(), array('CONTENT_TYPE' => 'application/json', 'HTTP_USER_AGENT' => 'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'), $requestContent);
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('http://tiny.cN');

        $this->assertEquals(1, $updatedUrl->getMobileRedirects());
        $this->assertEquals($targetUrl, $updatedUrl->getTargetMobileUrl());        
        $this->assertJsonResponse($response, 302);
    }

    public function testRedirectTabletAction() {
        $route =  $this->getUrl('api_url_redirect~json');
        $requestContent = json_encode(array(
            'tiny_url' => 'http://tiny.cN',
        ));

        $this->client->request('GET', $route, array(), array(), array('CONTENT_TYPE' => 'application/json', 'HTTP_USER_AGENT' => 'Mozilla/5.0 (Tablet; rv:26.0) Gecko/26.0 Firefox/26.0'), $requestContent);
        $response = $this->client->getResponse();
        $targetUrl = $response->getTargetUrl();

        $urlRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ApiBundle:Url');
        $updatedUrl = $urlRepository->findOneByTinyUrl('http://tiny.cN');

        $this->assertEquals(1, $updatedUrl->getTabletRedirects());
        $this->assertEquals($targetUrl, $updatedUrl->getTargetTabletUrl());        
        $this->assertJsonResponse($response, 302);
    }


    
}