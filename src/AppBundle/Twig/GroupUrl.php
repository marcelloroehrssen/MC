<?php

namespace AppBundle\Twig;

use AppBundle\Entity\User;
use Symfony\Component\Routing\Router;
use Twig_SimpleFilter;
use Twig_Extension;

/**
 * Created by PhpStorm.
 * User: Ixia
 * Date: 22/03/18
 * Time: 23:40
 */
class GroupUrl extends Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * GroupUrl constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('group_url', array($this, 'groupUrl')),
        );
    }

    public function groupUrl(User $group)
    {
        $groupNameLong = $group->getGroupNameLong();
        if (empty($groupNameLong)) {
            return $group->getId() . '-group';
        }
        preg_match('/([a-zA-Z0-9 ]+)/', $groupNameLong, $matches);

//        ($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH

        return str_replace(' ', '-', strtolower($matches[1]));
    }
}