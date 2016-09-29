<?php

namespace ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ApiBundle\Entity\Url;

class LoadUrlData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $urlContent = array(
            array('tinyUrl' => 'http://mytiny/1', 'targetUrl' => 'http://longOriginal/1'),
            array('tinyUrl' => 'http://mytiny/2', 'targetUrl' => 'http://longOriginal/2'),
            array('tinyUrl' => 'http://mytiny/3', 'targetUrl' => 'http://longOriginal/3'),
            array('tinyUrl' => 'http://mytiny/4', 'targetUrl' => 'http://longOriginal/4'),
            array('tinyUrl' => 'http://mytiny/5', 'targetUrl' => 'http://longOriginal/5'),
            array('tinyUrl' => 'http://mytiny/6', 'targetUrl' => 'http://longOriginal/6'),
            array('tinyUrl' => 'http://mytiny/7', 'targetUrl' => 'http://longOriginal/7'),
            array('tinyUrl' => 'http://mytiny/8', 'targetUrl' => 'http://longOriginal/8'),
            array('tinyUrl' => 'http://mytiny/9', 'targetUrl' => 'http://longOriginal/9'),
            array('tinyUrl' => 'http://mytiny/10', 'targetUrl' => 'http://longOriginal/10'),
            array('tinyUrl' => 'http://mytiny/11', 'targetUrl' => 'http://longOriginal/11')
        );

        foreach ($urlContent as $url) {
            $newUrl = new Url();
            if (array_key_exists('tinyUrl', $url)) {
                $newUrl->setTinyUrl($url['tinyUrl']);
            }
            if (array_key_exists('targetUrl', $url)) {
                $newUrl->setTargetUrl($url['targetUrl']);
            }
            $newUrl->setTimeStamp(new \DateTime("now"));
            $manager->persist($newUrl);
        }

        $manager->flush();
    }
}