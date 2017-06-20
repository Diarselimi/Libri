<?php

namespace AppBundle\Controller\Web\Library;

use AppBundle\Entity\Book;
use AppBundle\Entity\UserBook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository(UserBook::class)->findBy(['user' => $this->getUser()]);

        return $this->render('AppBundle:library:dashboard.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @param Request $request
     * @Route("/import", name="library_import_books")
     */
    public function importAction(Request $request)
    {
        $translator = $this->get('translator');
        $data = $request->request->get('book');
        $tempFile = $request->files->get('books-file');
        $this->get('app.excel_import_manager')->prepare($data, $tempFile, $this->getUser());
        $this->addFlash('success', $translator->trans('book.import_sucessfully'));

        return $this->redirectToRoute('library_dashboard');
    }
}