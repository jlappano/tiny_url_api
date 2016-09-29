<?php

namespace Tests\ApiBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase {

    public function setUp(){
        $this->client = static::createClient();
        $this->expected = '[{"tinyUrl":"cj","timeStamp":"2016-01-01T00:00:00+01:00","redirect":null},{"tinyUrl":"9m","timeStamp":"2016-01-02T00:00:00+01:00","redirect":null},{"tinyUrl":"cN","timeStamp":"2016-01-03T00:00:00+01:00","redirect":null},{"tinyUrl":"3k","timeStamp":"2016-01-04T00:00:00+01:00","redirect":null},{"tinyUrl":"5nb","timeStamp":"2016-01-05T00:00:00+01:00","redirect":null},{"tinyUrl":"5vRRM","timeStamp":"2016-01-06T00:00:00+01:00","redirect":null},{"tinyUrl":"7Gqp","timeStamp":"2016-01-07T00:00:00+01:00","redirect":null},{"tinyUrl":"3664Ft","timeStamp":"2016-01-08T00:00:00+01:00","redirect":null},{"tinyUrl":"4N7-","timeStamp":"2016-01-09T00:00:00+01:00","redirect":null},{"tinyUrl":"7GPb","timeStamp":"2016-01-10T00:00:00+01:00","redirect":null},{"tinyUrl":"jLG","timeStamp":"2016-01-11T00:00:00+01:00","redirect":null}]';
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
        // var_dump($content);

        $this->assertJsonResponse($response, 200);
        $this->assertEquals($this->expected, $content);
    }
    
}