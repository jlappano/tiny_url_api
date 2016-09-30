<?php

namespace ApiBundle\Service;

/**
 * Class DeviceDetectService
 * @package Relay\RiseBundle\Service
 */
class DeviceDetectService
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