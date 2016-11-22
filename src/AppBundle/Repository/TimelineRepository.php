<?php
namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TimelineRepository extends EntityRepository
{
    public function getAllAndOrderByLatest($limit = 20, $offset = 0)
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}