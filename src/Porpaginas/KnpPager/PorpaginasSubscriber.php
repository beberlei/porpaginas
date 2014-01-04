<?php

namespace Porpaginas\KnpPager;

use Porpaginas\Page;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;

class PorpaginasSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event)
    {
        if ( ! ($event->target instanceof Page)) {
            return;
        }

        $page = $event->target;

        $event->count = $page->totalCount();
        $event->items = $page->getIterator();
        $event->stopPropagation();
    }

    public static function getSubscribedEvents()
    {
        return array(
            'knp_pager.items' => array('items', 0)
        );
    }
}
