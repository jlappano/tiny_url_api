<?php

namespace ApiBundle\Service;

/**
 * Class UserAgentService
 * @package Relay\RiseBundle\Service
 */
class UserAgentService
{

    public function isMobile($userAgent)
    {
        if (strpos($userAgent, 'Mobi') !== false) {
            return 'true';
        }

        return false;
    }

    public function isTablet($userAgent)
    {
        if (strpos($userAgent, 'Tablet') !== false) {
            return 'true';
        }
        
        return false;
    }
}