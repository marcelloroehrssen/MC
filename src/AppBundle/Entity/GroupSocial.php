<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupSocial
 *
 * @ORM\Table(name="group_social")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupSocialRepository")
 */
class GroupSocial
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
     * @var Social
     *
     * @ORM\OneToOne(targetEntity="Social")
     * @ORM\JoinColumn(name="social_id", referencedColumnName="id")
     */
    private $social;

    /**
     * @var string
     *
     * @ORM\Column(name="socialLink", type="string", length=255)
     */
    private $socialLink;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy="Socials")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Social
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param Social $social
     */
    public function setSocial($social)
    {
        $this->social = $social;
    }

    /**
     * @return string
     */
    public function getSocialLink()
    {
        return $this->socialLink;
    }

    /**
     * @param string $socialLink
     */
    public function setSocialLink($socialLink)
    {
        $this->socialLink = $socialLink;
    }

    /**
     * @return User
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param User $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
}

