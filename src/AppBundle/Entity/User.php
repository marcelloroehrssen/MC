<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="groupName", type="string", length=255, nullable=true)
     */
    private $groupName;

    /**
     * @var Events
     *
     * @ORM\OneToMany(targetEntity="Events", mappedBy="user")
     */
    private $events;

    /**
     * @var string
     *
     * @ORM\Column(name="groupNameLong", type="string", length=255, nullable=true)
     */
    private $groupNameLong;

    /**
     * @var string
     *
     * @ORM\Column(name="keyUrl", type="string", length=255)
     */
    private $keyUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=32)
     */
    private $genre = 'folk';

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var array
     *
     * @ORM\OneToOne(targetEntity="GroupNews", mappedBy="group")
     */
    private $news;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="GroupSocial", mappedBy="group")
     */
    private $socials;

    /**
     * @ORM\OneToOne(targetEntity="GroupExtendedInfo")
     * @ORM\JoinColumn(name="extended_info_id", referencedColumnName="id")
     */
    private $extendedInfo;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Page", inversedBy="admins")
     * @ORM\JoinTable(name="users_pages")
     */
    private $pages;

    private $follower;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_USER'];
        $this->pages = new ArrayCollection();
    }


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
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getGroupNameLong()
    {
        return $this->groupNameLong;
    }

    /**
     * @param string $groupNameLong
     */
    public function setGroupNameLong($groupNameLong)
    {
        $this->groupNameLong = $groupNameLong;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return array
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param array $news
     */
    public function setNews($news)
    {
        $this->news = $news;
    }

    /**
     * @return array
     */
    public function getSocials()
    {
        return $this->socials;
    }

    /**
     * @param array $socials
     */
    public function setSocials($socials)
    {
        $this->socials = $socials;
    }

    /**
     * @return mixed
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * @param mixed $follower
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;
    }

    /**
     * @return mixed
     */
    public function getExtendedInfo()
    {
        return $this->extendedInfo;
    }

    /**
     * @param mixed $extendedInfo
     */
    public function setExtendedInfo($extendedInfo)
    {
        $this->extendedInfo = $extendedInfo;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getKeyUrl()
    {
        return $this->keyUrl;
    }

    /**
     * @param string $keyUrl
     */
    public function setKeyUrl($keyUrl)
    {
        $this->keyUrl = $keyUrl;
    }

    public function addPage(Page $page)
    {
        $this->pages[] = $page;
    }

    public function getPages()
    {
        return $this->pages;
    }

    /** @ORM\PrePersist */
    public function prePersist()
    {
        $this->keyUrl = str_replace(" ","-",strtolower($this->groupNameLong));
    }
}

