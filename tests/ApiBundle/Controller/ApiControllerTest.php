<?php

namespace Tests\ApiBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase {

    public function setUp(){
        $this->client = static::createClient();
        $this->expectedList = '[{"tinyUrl":"http:\/\/cj","timeStamp":"2016-01-01T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/9m","timeStamp":"2016-01-02T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/cN","timeStamp":"2016-01-03T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/3k","timeStamp":"2016-01-04T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/5nb","timeStamp":"2016-01-05T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/5vRRM","timeStamp":"2016-01-06T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/7Gqp","timeStamp":"2016-01-07T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/3664Ft","timeStamp":"2016-01-08T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/4N7-","timeStamp":"2016-01-09T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/7GPb","timeStamp":"2016-01-10T00:00:00+01:00","redirect":null},{"tinyUrl":"http:\/\/jLG","timeStamp":"2016-01-11T00:00:00+01:00","redirect":null}]';
        $this->expectedTinyUrl = '{"tiny url":"http:\/\/tiny.38"}';
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

        $this->assertJsonResponse($response, 200);
        $this->assertEquals($this->expectedList, $content);
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
    
}