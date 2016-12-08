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
use AppBundle\Entity\UserBookShelf;
use AppBundle\Utils\ChartsData;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserBookShelfController extends BaseController
{
    /**
     * This function will return the books read in this year
     * @Route("/userbook", name="get_data_for_one_year")
     * @Method(methods={"get"})
     * @ApiDoc(
     *  resource=true,
     *  )
     */
    public function getBooksReadPerMonthAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $userBookShelf = $em->getRepository(UserBookShelf::class)->findAllForThisYear($user);
        $charts = new ChartsData();
        $data = $charts->countBooksByMonth($userBookShelf);
        return $this->createApiResponse($data);
    }
}