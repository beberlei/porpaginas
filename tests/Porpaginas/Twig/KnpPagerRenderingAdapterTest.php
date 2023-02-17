<?php

namespace Porpaginas\Twig;

use Knp\Component\Pager\ArgumentAccess\ArgumentAccessInterface;
use Knp\Component\Pager\Event\ItemsEvent;
use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Porpaginas\Arrays\ArrayPage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;

class KnpPagerRenderingAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_pagination_delegating_to_twig_knppagination()
    {
        $env = \Phake::mock('Twig\Environment');
        $extension = \Phake::mock('Porpaginas\Twig\KnpPaginationExtension');

        \Phake::when($env)->getExtension('knp_pagination')->thenReturn($extension);

        $paginator = new \Knp\Component\Pager\Paginator(
            $eventDispatcher = new EventDispatcher(),
            \Phake::mock(ArgumentAccessInterface::class),
        );

        $eventDispatcher->addListener('knp_pager.items', function (ItemsEvent $event) {
            $event->stopPropagation();
            $event->count = 0;
            $event->items = [];
        });
        $eventDispatcher->addListener('knp_pager.pagination', function (PaginationEvent $event) {
            $event->stopPropagation();
            $event->setPagination(new SlidingPagination());
        });

        $adapter = new KnpPagerRenderingAdapter($paginator);
        $page = new ArrayPage(array(1, 2), 10, 10, 2);

        $adapter->renderPagination($page, $env);

        \Phake::verify($extension)->render(\Phake::anyParameters());
    }
}

class KnpPaginationExtension extends \Twig\Extension\AbstractExtension
{
    public function render($items, $template)
    {
    }

    public function getName()
    {
        return 'knp_pagination';
    }
}
