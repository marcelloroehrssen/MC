<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventsRepository")
 */
class Events
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOpen", type="datetime")
     */
    private $dateOpen;

    /**
     * @var int
     *
     * @ORM\Column(name="standsMaxNumber", type="integer")
     */
    private $standsMaxNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="event", cascade={"persist"})
     */
    private $stages;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function __construct()
    {
        $this->dateOpen = new \DateTime();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Events
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Events
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Events
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateOpen
     *
     * @param \DateTime $dateOpen
     *
     * @return Events
     */
    public function setDateOpen($dateOpen)
    {
        $this->dateOpen = $dateOpen;

        return $this;
    }

    /**
     * Get dateOpen
     *
     * @return \DateTime
     */
    public function getDateOpen()
    {
        return $this->dateOpen;
    }

    /**
     * Set standsMaxNumber
     *
     * @param integer $standsMaxNumber
     *
     * @return Events
     */
    public function setStandsMaxNumber($standsMaxNumber)
    {
        $this->standsMaxNumber = $standsMaxNumber;

        return $this;
    }

    /**
     * Get standsMaxNumber
     *
     * @return int
     */
    public function getStandsMaxNumber()
    {
        return $this->standsMaxNumber;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return array
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * @param array $stages
     */
    public function setStages($stages)
    {
        $this->stages = $stages;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

