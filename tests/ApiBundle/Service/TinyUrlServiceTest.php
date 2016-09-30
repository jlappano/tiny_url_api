<?php

namespace Tests\ApiBundle\Service;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class TinyUrlServiceTest extends WebTestCase {

    private $urlService;

    public function setUp()
    {
        self::bootKernel();
        $this->urlService = static::$kernel->getContainer()->get('url_service');
    }

    public function testEncode() {
        $this->assertEquals(
            $this->urlService->encode(17772202030033),
            'http://tiny.qQ_TRh4x'
        );
    }

    public function testDecode() {
        $this->assertEquals(
            $this->urlService->decode('http://tiny.qQ_TRh4x'),
            17772202030033
        );
    }
    
}