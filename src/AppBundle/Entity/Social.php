<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Social
 *
 * @ORM\Table(name="social")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocialRepository")
 */
class Social
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
     * @ORM\Column(name="socialName", type="string", length=255)
     */
    private $socialName;


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
     * Set socialName
     *
     * @param string $socialName
     *
     * @return Social
     */
    public function setSocialName($socialName)
    {
        $this->socialName = $socialName;

        return $this;
    }

    /**
     * Get socialName
     *
     * @return string
     */
    public function getSocialName()
    {
        return $this->socialName;
    }
}

