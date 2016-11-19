<?php
namespace AppBundle\Services;


use AppBundle\Entity\Review;
use AppBundle\Entity\Timeline;
use AppBundle\Entity\UserBookShelf;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TimelineLogger implements EventSubscriber
{
    private $currentEntity = null;
    private $timelineEntities = [
        Review::class,
        UserBookShelf::class
    ];

    private $timelineMessages = [
        'review' => [
            'title' => 'Book review',
            'description' => '%s'
        ],
        'userbookshelf' => [
            'title' => 'Shelf updated',
            'description' => 'You added the book %s to the shelf %s'
        ]
    ];

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // for now I am logging only the review for the book
        if ($this->isForTimeline($entity)) {
            $em = $args->getEntityManager();
            $timeline = new Timeline();
            $timeline->setTitle($this->getTitle());

            $second = null;
            if($entity instanceof Review) {
                $desc = $entity->getReview();
            }else{
                $desc = $entity->getBook()->getTitle();
                $second = $entity->getShelf()->getName();
            }

            $timeline->setDescription($this->getDescription($desc, $second));
            $timeline->setTable('Review');
            $timeline->setParentId($entity->getBook()->getId());
            $timeline->setLink('no link');
            $timeline->setUserId($entity->getUser()->getId());
            
            $em->persist($timeline);
            $em->flush();

        }
    }

    /**
     * This function will check if the entity will be added in the timeline event.
     * @param $newEntity
     * @return bool
     */
    protected function isForTimeline($newEntity)
    {
        foreach ($this->timelineEntities as $entity) {
            $entity = new $entity();
            if($entity instanceof $newEntity) {
                $this->currentEntity = (new \ReflectionClass($newEntity))->getShortName();
                return true;
            }
        }
        return false;
    }

    protected function getTitle()
    {
        return $this->timelineMessages[strtolower($this->currentEntity)]['title'];
    }

    protected function getDescription($val1, $val2 = null)
    {
        return sprintf($this->timelineMessages[strtolower($this->currentEntity)]['description'], $val1, $val2);
    }
}