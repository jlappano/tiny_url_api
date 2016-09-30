<?php

namespace Tests\ApiBundle\Service;

use Liip\FunctionalTestBundle\Test\WebTestCase;

//Sample User agent strings sourced from http://www.useragentstring.com/pages/useragentstring.php
class UserAgentServiceTest extends WebTestCase {

    private $userAgentService;
    private $mobileUserAgents;
    private $tabletUserAgents;
    private $desktopUserAgents;

    public function setUp()
    {
        self::bootKernel();
        $this->userAgentService = static::$kernel->getContainer()->get('user_agent_service');
        $this->mobileUserAgents = array(
            'Mozilla/5.0 (Linux; U; Android 2.3.4; fr-fr; HTC Desire Build/GRJ22)
            AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
            'Mozilla/5.0 (BlackBerry; U; BlackBerry 9860; en-US) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.254 Mobile Safari/534.11+',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)',
            'Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02'
        );
        $this->tabletUserAgents = array(
            'Mozilla/5.0 (Tablet; rv:26.0) Gecko/26.0 Firefox/26.0',
            'Mozilla/5.0 (Linux; <Android Version>; <Build Tag etc.>) AppleWebKit/<WebKit Rev>(KHTML, like Gecko) Chrome/<Chrome Rev> Safari/<WebKit Rev>',
            'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10'
        );
        $this->desktopUserAgents = array(
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0'
        );
    }

    public function testIsMobile() {
        foreach ($this->mobileUserAgents as $userAgent) {
            $this->assertTrue($this->userAgentService->isMobile($userAgent));
        }
        foreach ($this->tabletUserAgents as $userAgent) {
            $this->assertFalse($this->userAgentService->isMobile($userAgent));
        }
        foreach ($this->desktopUserAgents as $userAgent) {
            $this->assertFalse($this->userAgentService->isMobile($userAgent));
        }
    }

    public function testIsTablet() {
        foreach ($this->mobileUserAgents as $userAgent) {
            $this->assertFalse($this->userAgentService->isTablet($userAgent));
        }
        foreach ($this->tabletUserAgents as $userAgent) {
            $this->assertTrue($this->userAgentService->isTablet($userAgent));
        }
        foreach ($this->desktopUserAgents as $userAgent) {
            $this->assertFalse($this->userAgentService->isTablet($userAgent));
        }
    }
    
}