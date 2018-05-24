<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserEventRepository extends EntityRepository
{
    public function getByUserAndEvent($user, $event)
    {
        return $this->createQueryBuilder('ue')
            ->where('ue.user = :user')
            ->andWhere('ue.event = :event')
            ->setParameter('user', $user)
            ->setParameter('event', $event)
            ->getQuery()
            ->getResult();
    }
}