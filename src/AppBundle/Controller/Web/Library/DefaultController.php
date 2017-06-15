<?php

namespace AppBundle\Controller\Web\Library;

use AppBundle\Entity\Book;
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
        return $this->render('AppBundle:library:dashboard.html.twig');
    }

    /**
     * @param Request $request
     * @Route("/import", name="library_import_books")
     */
    public function importAction(Request $request)
    {
        $data = $request->request->get('book');
        $tempFile = $request->files->get('books-file');
//        dump($data);die;
        $excel = $this->get('phpexcel')->createPHPExcelObject($tempFile->getRealPath());

        $books = [];

        for ($j=1; $j <= count($data); $j++) {
            for ($i=1; $i < $excel->getActiveSheet()->getHighestRow(); $i++) {
                $tempBook = new Book();
                $tempBook->setIsForSale(true);
                $func = 'set'.ucfirst($data[$i]);
                $tempBook->$func($excel->getActiveSheet()->getCellByColumnAndRow($i, $j)->getValue());
                dump($tempBook);die;
            }
        }
        die;
dump($excel->getActiveSheet()->getCellCollection());
dump($excel->getActiveSheet()->getHighestRow());die;
        foreach ($excel->getActiveSheet()->getCellByColumnAndRow()->getParent()->getHighestColumn() as $key => $colRow) {
            dump($excel->getActiveSheet()->getCellByColumnAndRow($colRow));
        }
        die;
    }
}