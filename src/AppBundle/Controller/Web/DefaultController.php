<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Book;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $limit = 5;
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository(Book::class)->searchAllBooks($request->query->get('search'), $limit);
        $ratedBooks = $em->getRepository(Book::class)->findMostRated($limit);
        $readedBooks = $em->getRepository(Book::class)->findMostReaded($limit);
        $categories = $em->getRepository(Category::class)->findAll();
        
        // replace this example code with whatever you need
        return $this->render('@App/dashboard.html.twig', [
            'books' => $books,
            'mostrated' => $ratedBooks,
            'mostreaded' => $readedBooks,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/books", name="search_for_books")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository(Book::class)->searchAllBooks($request->get('search'), 50);

        return $this->render('@App/book/search.html.twig', [
            'books' => $books
        ]);
    }
}
