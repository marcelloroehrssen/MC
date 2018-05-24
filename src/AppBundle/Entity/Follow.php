<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Follow
 *
 * @ORM\Table(name="follow")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FollowRepository")
 */
class Follow
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
     * @var Events
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $group;

    /**
     * @var Events
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="fan_id", referencedColumnName="id")
     */
    private $fan;

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
     * @return Events
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Events $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return Events
     */
    public function getFan()
    {
        return $this->fan;
    }

    /**
     * @param Events $fan
     */
    public function setFan($fan)
    {
        $this->fan = $fan;
    }
}

