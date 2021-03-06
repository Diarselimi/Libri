<?php
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserBookShelfRepository")
 * @ORM\Table(name="user_book_shelf")
 */
class UserBookShelf
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="shelfedBooks")
     * @Serializer\Exclude()
     * @Serializer\MaxDepth(1)
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book", inversedBy="usersShelfed")
     * @Serializer\MaxDepth(1)
     * @Serializer\Exclude()
     */
    private $book;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shelf", inversedBy="usersBooks")
     * @Serializer\MaxDepth(1)
     */
    private $shelf;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pages;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        if(!$this->getCreatedAt()) {
            $this->createdAt = new \DateTime();
        }
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserBookShelf
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return UserBookShelf
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserBookShelf
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set book
     *
     * @param \AppBundle\Entity\Book $book
     *
     * @return UserBookShelf
     */
    public function setBook(\AppBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \AppBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set shelf
     *
     * @param \AppBundle\Entity\Shelf $shelf
     *
     * @return UserBookShelf
     */
    public function setShelf(\AppBundle\Entity\Shelf $shelf = null)
    {
        $this->shelf = $shelf;

        return $this;
    }

    /**
     * Get shelf
     *
     * @return \AppBundle\Entity\Shelf
     */
    public function getShelf()
    {
        return $this->shelf;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }


}
