<?php
namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AuthorRepository extends EntityRepository
{
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('author')
            ->orderBy('author.firstName', 'ASC');
    }

    public function findOneByName($fullName)
    {
        $name = explode(' ', $fullName)[0];
        $lastName = explode(' ', $fullName)[1];

        return $this->createQueryBuilder('author')
            ->andWhere('author.firstName LIKE :fname OR author.lastName LIKE :fname')
            ->andWhere('author.lastName LIKE :lname OR author.firstName LIKE :lname')
            ->setParameter('fname', '%'. $name .'%')
            ->setParameter('lname', '%'. $lastName .'%')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}