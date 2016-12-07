<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 12/5/16
 * Time: 11:26 PM
 */

namespace AppBundle\Controller\Web;


use AppBundle\Controller\BaseController;
use AppBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RecommendController extends BaseController
{
    /**
     * @Route("/recommend", name="recommend_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('@App/recomend/index.html.twig');
    }
}