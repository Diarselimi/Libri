<?php namespace AppBundle\Controller\Web;



use AppBundle\Controller\BaseController;
use AppBundle\Entity\Book;
use AppBundle\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BaseController
{

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/category/{id}", name="show_books_by_category")
     */
    public function showAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository(Book::class)->findBy(['category' => $category]);

        return $this->render('@App/book/search.html.twig', [
            'books' => $books
        ]);
    }

}