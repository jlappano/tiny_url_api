<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Url
 *
 * @ORM\Table(name="url")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UrlRepository")
 */
class Url
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tinyUrl", type="string", length=255)
     */
    private $tinyUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeStamp", type="datetime")
     */
    private $timeStamp;

    /**
     * @var string
     *
     * @ORM\Column(name="targetUrl", type="string", length=255)
     */
    private $targetUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="redirectCount", type="integer", nullable=true)
     */
    private $redirectCount;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tinyUrl
     *
     * @param string $tinyUrl
     *
     * @return Url
     */
    public function setTinyUrl($tinyUrl)
    {
        $this->tinyUrl = $tinyUrl;

        return $this;
    }

    /**
     * Get tinyUrl
     *
     * @return string
     */
    public function getTinyUrl()
    {
        return $this->tinyUrl;
    }

    /**
     * Set timeStamp
     *
     * @param \DateTime $timeStamp
     *
     * @return Url
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    /**
     * Get timeStamp
     *
     * @return \DateTime
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Set targetUrl
     *
     * @param string $targetUrl
     *
     * @return Url
     */
    public function setTargetUrl($targetUrl)
    {
        $this->targetUrl = $targetUrl;

        return $this;
    }

    /**
     * Get targetUrl
     *
     * @return string
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * Set redirectCount
     *
     * @param integer $redirectCount
     *
     * @return Url
     */
    public function setRedirectCount($redirectCount)
    {
        $this->redirectCount = $redirectCount;

        return $this;
    }

    /**
     * Get redirectCount
     *
     * @return int
     */
    public function getRedirectCount()
    {
        return $this->redirectCount;
    }
}

