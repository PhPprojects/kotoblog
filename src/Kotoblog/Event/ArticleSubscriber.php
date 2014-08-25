<?php

namespace Kotoblog\Event;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kotoblog\Entity\Article;
use Kotoblog\Parsedown;

class ArticleSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(Events::prePersist, Events::preUpdate, Events::postPersist, Events::postUpdate);
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof Article) {
            $this->parseMarkdown($entity);
        }
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof Article) {
            $this->parseMarkdown($entity);
        }
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof Article) {
            // set cache
        }
    }

    public function postUpdate(LifecycleEventArgs $event)
    {

    }

    protected function parseMarkdown(Article $article)
    {
        $parsedown = new Parsedown();
        $parsedown->setBreaksEnabled(true);

        $text = $parsedown->text($article->getTextSource());
        $article->setText($text);
    }

    protected function updateWeightTags()
    {

    }
}
