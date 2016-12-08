<?php
namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Shelf;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadShelfData implements FixtureInterface 
{
    public function load(ObjectManager $em)
    {
        $shelf = [
            'Read' => 3,
            'Want to read' => 1,
            'Currently reading' => 2,
        ];

        foreach ($shelf as $item => $order) {
            $sh = new Shelf();
            $sh->setName($item);
            $sh->setOrder($order);
            $em->persist($sh);
            $em->flush();
        }
    }
}