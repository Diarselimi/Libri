<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 16-11-21
 * Time: 10.21.MD
 */
namespace AppBundle\Controller\Api;


use AppBundle\Controller\BaseController;
use AppBundle\Entity\Book;
use AppBundle\Entity\UserBookShelf;
use AppBundle\Form\BookPagesReadType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BookController extends BaseController
{
    /**
     * This function will return the timeline items
     * @Route("/book/{id}/page")
     * @Method(methods={"post"})
     * @ApiDoc(
     *  resource=true,
     *  description="This function will update the current page for a specific book.",
     *     filters={
            {"name"="current_page", "dataType"="integer"}
     *     }
     * )
     */
    public function pageUpdateAction(Request $request, Book $book)
    {

        $em = $this->getDoctrine()->getManager();
        $bookInShelf = $em->getRepository(UserBookShelf::class)->findOneBy(['book' => $book->getId(), 'user' => $this->getUser()->getId()]);
        $form = $this->createForm(BookPagesReadType::class, $bookInShelf);

        $form->handleRequest($request);

        if($form->isValid()) {
            $bookInShelf = $form->getData();

            $em->persist($bookInShelf);
            $em->flush();
            return $this->createApiResponse($bookInShelf);
        }

        return new JsonResponse('Something went wrong.', 400);
    }
}