<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 16-11-22
 * Time: 3.29.PD
 */

namespace AppBundle\Controller\Api;


use AppBundle\Controller\BaseController;
use AppBundle\Entity\Book;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserBookShelfController extends BaseController
{
    /**
     * This function will return the timeline items
     * @Route("/userbook/{book}")
     * @Method(methods={"get"})
     * @ApiDoc(
     *  resource=true,
     *  )
     */
    public function getBooksReadPerMonthAction(Request $request, Book $book)
    {
        
    }
}