<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Review;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension
{
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('avg', array($this, 'findAvarage')),
            new \Twig_SimpleFilter('isNavActive', array($this, 'isNavActive')),
            new \Twig_SimpleFilter('does_file_exists', array($this, 'fileExists')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function findAvarage(PersistentCollection $collection)
    {
        $counter = 0;
        $total = 0;
        foreach ($collection as $item) {
            if($item instanceof Review) {
                $total += $item->getRating();
                $counter ++;
            }
        }
        if ($total == 0) {
            return 0;
        }
        return $total / $counter;
    }

    public function getName()
    {
        return 'app_extension';
    }

    /**
     * This function will recieve the path name and will check if that is the current path that we are in
     * @param $path
     * @return bool
     */
    public function isNavActive($path, $currentPath, $active = 'active')
    {
        if($path == $currentPath) {
            return $active;
        }else{
            return "";
        }
    }

    public function fileExists($filePath)
    {
        $filePath = __DIR__.'/../../../web/uploads/covers/'.$filePath;
        if(file_exists($filePath))
            return true;
        return false;
    }
}