<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase {

    public function setUp(){
        $this->client = static::createClient();
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

    public function testListAction() {
        $route =  $this->getUrl('api_url_list~json');

        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $content = $response->getContent();
        var_dump($content);

        $this->assertJsonResponse($response, 200);
        $this->assertEquals('{"name":"list action"}', $content);
    }
    
}