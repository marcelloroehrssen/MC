<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page
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
     * @ORM\Column(name="group_name_short", type="string", length=255, nullable=true)
     */
    private $groupName;

    /**
     * @ORM\Column(name="group_name_long", type="string", length=255, nullable=true)
     */
    private $groupNameLong;

    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="pages")
     */
    private $admins;


    /**
     * One Product has One Shipment.
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="founder_id", referencedColumnName="id")
     */
    private $founder;

    /**
     * Page constructor.
     * @param int $id
     */
    public function __construct()
    {
        $this->admins = new ArrayCollection();
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
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return mixed
     */
    public function getGroupNameLong()
    {
        return $this->groupNameLong;
    }

    /**
     * @param mixed $groupNameLong
     */
    public function setGroupNameLong($groupNameLong)
    {
        $this->groupNameLong = $groupNameLong;
    }

    /**
     * @return mixed
     */
    public function getAdmins()
    {
        return $this->admins;
    }


    public function addAdmin(User $user)
    {
        $user->addPage($this);
    }

    /**
     * @return mixed
     */
    public function getFounder()
    {
        return $this->founder;
    }

    /**
     * @param mixed $founder
     */
    public function setFounder($founder)
    {
        $this->founder = $founder;
    }
}

