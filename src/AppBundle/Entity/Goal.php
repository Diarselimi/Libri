<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Appbundle\Entity\User;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GoalRepository")
 * @ORM\Table(name="goal")
 */
class Goal 
{	
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
	private $id;
	/**
	 * @ORM\Column(type="string")
	 */
	private $description;
    /**
     * @ORM\Column(type="integer")
     */
    private $booksRead;
    /**
     * @ORM\Column(type="integer")
     */
    private $booksToRead;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $startedGoalAt;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $finishedGoalAt;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $expectedFinishingAt;
	/**
	 * @ORM\Column(type="date")
	 */
	private $createdAt;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function __construct()
    {
        $this->description = "This year i will read";
        $this->startedGoalAt = new \DateTime();
        $this->expectedFinishingAt = new \DateTime(date('Y').'-12-31');
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->booksRead = 0;
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
     * Set description
     *
     * @param \varchar $description
     *
     * @return Goal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return \varchar
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set startedGoalAt
     *
     * @param \DateTime $startedGoalAt
     *
     * @return Goal
     */
    public function setStartedGoalAt($startedGoalAt)
    {
        $this->startedGoalAt = $startedGoalAt;

        return $this;
    }

    /**
     * Get startedGoalAt
     *
     * @return \DateTime
     */
    public function getStartedGoalAt()
    {
        return $this->startedGoalAt;
    }

    /**
     * Set finishedGoalAt
     *
     * @param \DateTime $finishedGoalAt
     *
     * @return Goal
     */
    public function setFinishedGoalAt($finishedGoalAt)
    {
        $this->finishedGoalAt = $finishedGoalAt;

        return $this;
    }

    /**
     * Get finishedGoalAt
     *
     * @return \DateTime
     */
    public function getFinishedGoalAt()
    {
        return $this->finishedGoalAt;
    }

    /**
     * Set expectedFinishingAt
     *
     * @param \DateTime $expectedFinishingAt
     *
     * @return Goal
     */
    public function setExpectedFinishingAt($expectedFinishingAt)
    {
        $this->expectedFinishingAt = $expectedFinishingAt;

        return $this;
    }

    /**
     * Get expectedFinishingAt
     *
     * @return \DateTime
     */
    public function getExpectedFinishingAt()
    {
        return $this->expectedFinishingAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Goal
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
     * @return Goal
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
     * @param User $user
     *
     * @return Goal
     */
    public function setUser(User $user = null)
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
     * Set booksRead
     *
     * @param integer $booksRead
     *
     * @return Goal
     */
    public function setBooksRead($booksRead)
    {
        $this->booksRead = $booksRead;

        return $this;
    }

    /**
     * Get booksRead
     *
     * @return integer
     */
    public function getBooksRead()
    {
        return $this->booksRead;
    }

    /**
     * Set booksToRead
     *
     * @param integer $booksToRead
     *
     * @return Goal
     */
    public function setBooksToRead($booksToRead)
    {
        $this->booksToRead = $booksToRead;

        return $this;
    }

    /**
     * Get booksToRead
     *
     * @return integer
     */
    public function getBooksToRead()
    {
        return $this->booksToRead;
    }
}
