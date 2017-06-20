<?php

namespace AppBundle\Services;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use AppBundle\Entity\User;
use AppBundle\Entity\UserBook;
use Doctrine\ORM\EntityManager;

class ImportManager
{

    /**
     * @var \PHPExcel
     */
    private $excel;
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct($excel, EntityManager $em)
    {
        $this->excel = $excel;
        $this->em = $em;
    }

    public function prepare($configuration = [], $file, User $user)
    {
        $data = (object) array_flip($configuration);

        $excel = $this->excel->createPHPExcelObject($file->getRealPath());

        for ($row=1; $row <= count($configuration); $row++) {
            $author = $excel->getActiveSheet()->getCellByColumnAndRow($data->author, $row)->getValue();
            $book = $this
                ->createBook(
                    $excel->getActiveSheet()->getCellByColumnAndRow($data->title, $row)->getValue(),
                    $author
                );

            $tempBook = new UserBook();
            $tempBook->setForSale(true);
            $tempBook->setUser($user);
            $tempBook->setBook($book);
            $tempBook->setPrice($excel->getActiveSheet()->getCellByColumnAndRow($data->price, $row)->getValue());

            try {
                $this->em->persist($tempBook);
                $this->em->flush();
            } catch (\Exception $e) {
                die(' something went wrong while saving the book' . $e->getMessage());
            }
        }

        return true;
    }

    private function prepareAuthor($name)
    {
        $author = $this->em->getRepository(Author::class)->findOneByName($name);

        return $author ?: $this->createAuthor($name);
    }

    protected function createAuthor($name)
    {
        $name = explode(' ', $name);

        $author = new Author();
        $author->setFirstName($name[0]);
        $author->setLastName($name[1]);
        $author->setEmail('');

        $this->em->persist($author);
        $this->em->flush();

        return $author;
    }

    protected function createBook($title, $author)
    {
        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($this->prepareAuthor($author));
        $book->setCategory(null);
        $book->setDescription('');
        $book->setSlug('this-is-a-slug');
        $book->setPublishedAt(new \DateTime());

        return $book;
    }
}