<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Follow
 *
 * @ORM\Table(name="user_event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserEventRepository")
 */
class UserEvent
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
    private $user;

    /**
     * @var Events
     *
     * @ORM\OneToOne(targetEntity="Events")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Events $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Events
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Events $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }
}

