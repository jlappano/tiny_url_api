<?php

namespace ApiBundle\Service;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class UserAgentService
 * @package Relay\RiseBundle\Service
 */
class UserAgentService
{

    private $doctrine;

    public function __construct(Registry $doctrine) {
        $this->doctrine = $doctrine;
    }


    public function isMobile($userAgent)
    {
        if (strpos($userAgent, 'Mobi') !== false && strpos($userAgent, 'iPad') == false) {
            return true;
        }

        return false;
    }

    public function isTablet($userAgent)
    {
        if (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false || (strpos($userAgent, 'Android') !== false && strpos($userAgent, 'Mobi') == false)) {
            return true;
        }
        
        return false;
    }

    /*
    * Gets redirect url
    * Increments associated redirect count
    * Returns redirect url
    */
    public function getRedirectUrl($url, $userAgent)
    {
        $redirectUrl = '';
        $em = $this->doctrine->getManager();

        if($this->isMobile($userAgent) && !is_null($url->getTargetMobileUrl())){
            $redirectUrl = $url->getTargetMobileUrl();
            $url->incrementMobileRedirects();

        } elseif ($this->isTablet($userAgent) && !is_null($url->getTargetTabletUrl())) {
            $redirectUrl = $url->getTargetTabletUrl();
            $url->incrementTabletRedirects();

        } else {
            $redirectUrl = $url->getTargetDesktopUrl();
            $url->incrementDesktopRedirects();

        }
        $em->persist($url);
        $em->flush();
        return $redirectUrl;
    }
}