<?php

namespace AppBundle\Controller\Web\Library;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AppBundle\Controller\Web\Library
 * @Route("/library")
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="library_dashboard")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:library:dashboard.html.twig');
    }
}