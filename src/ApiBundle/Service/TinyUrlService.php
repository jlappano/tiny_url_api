<?php

namespace ApiBundle\Service;

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

    public function __construct() {
        $this->alphabet = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ-_';
        $this->base = 51;
    }

    public function encode($num)
    {
        $str = '';
        while ($num > 0) {
            $str = $this->alphabet[($num % $this->base)] . $str;
            $num = (int) ($num / $this->base);
        }
        return $str;
    }

    public function decode($str)
    {
        $num = 0;
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $num = $num * $this->base + strpos($this->alphabet, $str[$i]);
        }
        return $num;
    }
}