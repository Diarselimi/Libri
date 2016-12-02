<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 11/30/16
 * Time: 9:29 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Goal;
use Doctrine\ORM\EntityRepository;

class GoalRepository extends EntityRepository
{

    /**
     * @return Goal|null
     */
    public function findCurrentGoal()
    {
        return $this->createQueryBuilder('goal')
            ->andWhere('goal.createdAt >= :currentDate')
            ->setParameter('currentDate', new \DateTime(date('Y').'-01-01'))
            ->andWhere('goal.createdAt <= :endDate')
            ->setParameter('endDate', new \DateTime(date('Y').'-12-31'))
            ->getQuery()
            ->getOneOrNullResult();
    }
}