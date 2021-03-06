<?php

namespace ApiBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class TinyUrlService
 * @package Relay\RiseBundle\Service
 * Adapted from:
 * ShortURL (https://github.com/delight-im/ShortURL)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */
class TinyUrlService
{
    private $alphabet;
    private $base;
    private $doctrine;

    public function __construct(Registry $doctrine) {
        $this->alphabet = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ-_';
        $this->base = 51;
        $this->doctrine = $doctrine;
    }

    public function encode($num)
    {
        //generate num unique to DB
        while (!empty($this->doctrine->getRepository('ApiBundle:Url')->findOneByHash($num))) {
            $num = mt_rand(10000, 1000000);
        }

        $str = '';
        while ($num > 0) {
            $str = $this->alphabet[($num % $this->base)] . $str;
            $num = (int) ($num / $this->base);
        }
        return 'tiny.' . $str;
    }

    public function decode($str)
    {
        $url = $this->doctrine->getRepository('ApiBundle:Url')->findOneByTinyUrl($str);
        if(empty($url)){
            return '';
        }
        return $url->getHash();
    }
}