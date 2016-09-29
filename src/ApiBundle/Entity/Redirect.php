<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Redirect
 *
 * @ORM\Table(name="redirect")
 * @ORM\Entity()
 */
class Redirect
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
     * @ORM\OneToOne(targetEntity="Url")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     **/
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="desktopRedirects", type="integer")
     */
    private $desktopRedirects = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="tabletRedirects", type="integer")
     */
    private $tabletRedirects = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="mobileRedirects", type="integer")
     */
    private $mobileRedirects = 0;



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
     * Set desktopRedirects
     *
     * @param string $desktopRedirects
     *
     * @return Redirect
     */
    public function setDesktopRedirects($desktopRedirects)
    {
        $this->desktopRedirects = $desktopRedirects;

        return $this;
    }

    /**
     * Get desktopRedirects
     *
     * @return integer
     */
    public function getDesktopRedirects()
    {
        return $this->desktopRedirects;
    }

    /**
     * Set tabletRedirects
     *
     * @param string $tabletRedirects
     *
     * @return Redirect
     */
    public function setTabletRedirects($tabletRedirects)
    {
        $this->tabletRedirects = $tabletRedirects;

        return $this;
    }

    /**
     * Get tabletRedirects
     *
     * @return integer
     */
    public function getTabletRedirects()
    {
        return $this->tabletRedirects;
    }

    /**
     * Set mobileRedirects
     *
     * @param string $mobileRedirects
     *
     * @return Redirect
     */
    public function setMobileRedirects($mobileRedirects)
    {
        $this->mobileRedirects = $mobileRedirects;

        return $this;
    }

    /**
     * Get mobileRedirects
     *
     * @return integer
     */
    public function getMobileRedirects()
    {
        return $this->mobileRedirects;
    }

}

