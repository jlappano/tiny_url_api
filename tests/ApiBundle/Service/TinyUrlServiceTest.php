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
        $fixtures = array('ApiBundle\DataFixtures\ORM\LoadUrlData');
        $this->loadFixtures($fixtures);
        $firstUrl = $this->urlService->encode(38282);
        $secondUrl = $this->urlService->encode(38282);
        $this->assertNotEquals(
            $firstUrl,
            $secondUrl
        );
    }

    public function testDecode() {
        $fixtures = array('ApiBundle\DataFixtures\ORM\LoadUrlData');
        $this->loadFixtures($fixtures);
        $this->assertEquals(
            $this->urlService->decode('tiny.jLG'),
            38282
        );
    }
    
}