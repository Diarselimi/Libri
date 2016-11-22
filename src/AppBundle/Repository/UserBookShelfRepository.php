<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 16-11-22
 * Time: 8.44.MD
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserBookShelfRepository extends EntityRepository
{
    public function findAllForThisYear($user)
    {
        return $this->createQueryBuilder('ubsh')
            ->andWhere('ubsh.createdAt >= :startYear')
            ->andWhere('ubsh.createdAt <= :endYear')
            ->andWhere('ubsh.user = :user')
            ->setParameter('user', $user)
            ->setParameter('startYear', new \DateTime(date('Y').'-01-01'))
            ->setParameter('endYear', new \DateTime(date('Y').'-12-31'))
            ->getQuery()
            ->setMaxResults(10)
            ->getResult();
    }
}