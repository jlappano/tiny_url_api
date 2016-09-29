<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Url
 *
 * @ORM\Table(name="url")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UrlRepository")
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
     * @Groups({"listGroup"})
     * @ORM\Column(name="tinyDesktopUrl", type="string", length=255)
     */
    private $tinyUrl;

    /**
     * @var \DateTime
     *
     * @Groups({"listGroup"})
     * @ORM\Column(name="timeStamp", type="datetime")
     */
    private $timeStamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="hash", type="integer")
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="targetDesktopUrl", type="string", length=255, nullable=true)
     */
    private $targetDesktopUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="targetTabletUrl", type="string", length=255, nullable=true)
     */
    private $targetTabletUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="targetMobileUrl", type="string", length=255, nullable=true)
     */
    private $targetMobileUrl;

    /**
     * @Groups({"listGroup"})
     * @ORM\OneToOne(targetEntity="Redirect", mappedBy="url")
     **/
    private $redirect;


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
     * Set hash
     *
     * @param integer $hash
     *
     * @return Url
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return integer
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set targetDesktopUrl
     *
     * @param string $targetDesktopUrl
     *
     * @return Url
     */
    public function setTargetDesktopUrl($targetDesktopUrl)
    {
        $this->targetDesktopUrl = $targetDesktopUrl;

        return $this;
    }

    /**
     * Get targetDesktopUrl
     *
     * @return string
     */
    public function getTargetDesktopUrl()
    {
        return $this->targetDesktopUrl;
    }

    /**
     * Set targetTabletUrl
     *
     * @param string $targetTabletUrl
     *
     * @return Url
     */
    public function setTargetTabletUrl($targetTabletUrl)
    {
        $this->targetTabletUrl = $targetTabletUrl;

        return $this;
    }

    /**
     * Get targetTabletUrl
     *
     * @return string
     */
    public function getTargetTabletUrl()
    {
        return $this->targetTabletUrl;
    }

    /**
     * Set targetMobileUrl
     *
     * @param string $targetMobileUrl
     *
     * @return Url
     */
    public function setTargetMobileUrl($targetMobileUrl)
    {
        $this->targetMobileUrl = $targetMobileUrl;

        return $this;
    }

    /**
     * Get targetMobileUrl
     *
     * @return string
     */
    public function getTargetMobileUrl()
    {
        return $this->targetMobileUrl;
    }

    /**
     * Set redirect
     *
     * @param Redirect $redirect
     * @return Url
     */
    public function setRedirect(Redirect $redirect = null)
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * Get redirect
     *
     * @return redirect
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

}

