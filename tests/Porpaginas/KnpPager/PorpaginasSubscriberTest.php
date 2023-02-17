<?php

namespace Porpaginas\KnpPager;

use Knp\Component\Pager\Event\ItemsEvent;
use Porpaginas\Arrays\ArrayPage;
use PHPUnit\Framework\TestCase;

class PorpaginasSubscriberTest extends TestCase
{
    /**
     * @test
     */
    public function it_handles_and_converts_page()
    {
        $event = new ItemsEvent(10, 10);
        $event->target = new ArrayPage(array(1, 2), 10, 10, 2);

        $subscriber = new PorpaginasSubscriber();
        $subscriber->items($event);

        $this->assertEquals(2, $event->count);
        $this->assertEquals(array(1, 2), iterator_to_array($event->items));
    }
}
