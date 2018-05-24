<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupToken
 *
 * @ORM\Table(name="group_token")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupTokenRepository")
 */
class GroupToken
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
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;

    /**
     * @var int
     *
     * @ORM\Column(name="follower", type="integer", nullable=true)
     */
    private $follower;

    /**
     * @var GroupToken
     *
     * @ORM\OneToOne(targetEntity="GroupSocial")
     */
    private $groupSocial;

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
     * Set token
     *
     * @param string $token
     *
     * @return GroupToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set follower
     *
     * @param integer $follower
     *
     * @return GroupToken
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return int
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * @return GroupToken
     */
    public function getGroupSocial()
    {
        return $this->groupSocial;
    }

    /**
     * @param GroupToken $groupSocial
     */
    public function setGroupSocial($groupSocial)
    {
        $this->groupSocial = $groupSocial;
    }
}

