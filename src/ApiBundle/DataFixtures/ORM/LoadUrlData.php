<?php

namespace ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ApiBundle\Entity\Url;
use ApiBundle\Service\TinyUrlService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUrlData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
    */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $urlContent = array(
            array('timeStamp' => '2016-01-01', 'hashKey' => 473, 'targetDesktop' => 'https://www.youtube.com/'),
            array('timeStamp' => '2016-01-02', 'hashKey' => 373, 'targetDesktop' => 'https://www.youtube.com/','targetTablet' => 'http://tabletUrl/2293847373'),
            array('timeStamp' => '2016-01-03', 'hashKey' => 497, 'targetDesktop' => 'https://www.youtube.com/','targetTablet' => 'http://tabletUrl/3938130497','targetMobile' => 'http://mobileUrl/3938130497'),
            array('timeStamp' => '2016-01-04', 'hashKey' => 66, 'targetDesktop' => 'http://desktopUrl/423413566','targetTablet' => 'http://tabletUrl/423413566','targetMobile' => 'http://mobileUrl/423413566'),
            array('timeStamp' => '2016-01-05', 'hashKey' => 8678, 'targetDesktop' => 'http://desktopUrl/58678678678','targetMobile' => 'http://mobileUrl/58678678678'),
            array('timeStamp' => '2016-01-06', 'hashKey' => 23455345, 'targetDesktop' => 'http://desktopUrl/623423423455345','targetMobile' => 'http://mobileUrl/623423423455345'),
            array('timeStamp' => '2016-01-07', 'hashKey' => 747474, 'targetDesktop' => 'http://desktopUrl/7982374747474','targetMobile' => 'http://mobileUrl/7982374747474'),
            array('timeStamp' => '2016-01-08', 'hashKey' => 372623464, 'targetDesktop' => 'http://desktopUrl/8376455372623464','targetTablet' => 'http://tabletUrl/8376455372623464','targetMobile' => 'http://mobileUrl/8376455372623464'),
            array('timeStamp' => '2016-01-09', 'hashKey' => 364444, 'targetDesktop' => 'http://desktopUrl/9534627364444','targetTablet' => 'http://tabletUrl/9534627364444','targetMobile' => 'http://mobileUrl/9534627364444'),
            array('timeStamp' => '2016-01-10', 'hashKey' => 748484, 'targetDesktop' => 'http://desktopUrl/1002394748484','targetTablet' => 'http://tabletUrl/1002394748484'),
            array('timeStamp' => '2016-01-11', 'hashKey' => 38282, 'targetDesktop' => 'http://desktopUrl/126363638282')
        );

        foreach ($urlContent as $url) {
            $newUrl = new Url();

            $urlService = $this->container->get('url_service');

            if (array_key_exists('timeStamp', $url)) {
                $newUrl->setTimeStamp(new \DateTime($url['timeStamp']));
            }

            if (array_key_exists('targetDesktop', $url)) {
                $newUrl->setTargetDesktopUrl($url['targetDesktop']);
            }

            if (array_key_exists('targetTablet', $url)) {
                $newUrl->setTargetTabletUrl($url['targetTablet']);
            }

            if (array_key_exists('targetMobile', $url)) {
                $newUrl->setTargetMobileUrl($url['targetMobile']);
            }

            if (array_key_exists('hashKey', $url)) {
                $tinyUrl = $urlService->encode(intval($url['hashKey']));
                $newUrl->setHash(intval($url['hashKey']));
                $newUrl->setTinyUrl($tinyUrl);
            }

            $manager->persist($newUrl);
        }

        $manager->flush();
    }
}