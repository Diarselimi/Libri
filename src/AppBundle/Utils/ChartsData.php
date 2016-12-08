<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 16-11-22
 * Time: 9.12.MD
 */

namespace AppBundle\Utils;


use AppBundle\Entity\UserBookShelf;

class ChartsData
{
    private $months = [
        'January' => 0,
        'February' => 0,
        'March' => 0,
        'April' => 0,
        'May' => 0,
        'June' => 0,
        'July' => 0,
        'August' => 0,
        'September' => 0,
        'October' => 0,
        'November' => 0,
        'December' => 0
    ];

    private $values = [];
    /**
     * @param UserBookShelf[] $dbData
     * @return array
     */
    public function countBooksByMonth($dbData)
    {
        //iterate through the data
        foreach ($dbData as $userBookShelf) {
            $this->addToTheSpecificPosition($userBookShelf->getCreatedAt()->format('F'), 1);
        }
        return array_values($this->months);
    }

    private function addToTheSpecificPosition($location, $value)
    {
            $this->months[$location] += $value;
    }
}