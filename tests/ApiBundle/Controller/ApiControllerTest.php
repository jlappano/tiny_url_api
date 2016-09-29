<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase {

    public function setUp(){
        $this->client = static::createClient();
        $this->expected = '[{"id":1,"tinyUrl":"http:\/\/mytiny\/1","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/1","redirectCount":null},{"id":2,"tinyUrl":"http:\/\/mytiny\/2","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/2","redirectCount":null},{"id":3,"tinyUrl":"http:\/\/mytiny\/3","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/3","redirectCount":null},{"id":4,"tinyUrl":"http:\/\/mytiny\/4","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/4","redirectCount":null},{"id":5,"tinyUrl":"http:\/\/mytiny\/5","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/5","redirectCount":null},{"id":6,"tinyUrl":"http:\/\/mytiny\/6","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/6","redirectCount":null},{"id":7,"tinyUrl":"http:\/\/mytiny\/7","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/7","redirectCount":null},{"id":8,"tinyUrl":"http:\/\/mytiny\/8","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/8","redirectCount":null},{"id":9,"tinyUrl":"http:\/\/mytiny\/9","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/9","redirectCount":null},{"id":10,"tinyUrl":"http:\/\/mytiny\/10","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/10","redirectCount":null},{"id":11,"tinyUrl":"http:\/\/mytiny\/11","timeStamp":"2016-09-28T17:04:49+02:00","targetUrl":"http:\/\/longOriginal\/11","redirectCount":null}]';
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