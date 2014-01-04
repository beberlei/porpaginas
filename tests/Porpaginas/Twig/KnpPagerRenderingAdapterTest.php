<?php

namespace Porpaginas\Twig;

use Porpaginas\Arrays\ArrayPage;

class KnpPagerRenderingAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_renders_pagination_delegating_to_twig_knppagination()
    {
        $env = \Phake::mock('Twig_Environment');
        $extension = \Phake::mock('Porpaginas\Twig\KnpPaginationExtension');

        \Phake::when($env)->getExtension('knp_pagination')->thenReturn($extension);

        $paginator = \Phake::mock('Knp\Component\Pager\Paginator');

        $adapter = new KnpPagerRenderingAdapter($paginator);
        $page = new ArrayPage(array(1, 2), 10, 10, 2);

        $adapter->renderPagination($page, $env);

        \Phake::verify($paginator)->paginate($page, 2, 10);
        \Phake::verify($extension)->render(\Phake::anyParameters());
    }
}

class KnpPaginationExtension extends \Twig_Extension
{
    public function render($items, $template)
    {
    }

    public function getName()
    {
        return 'knp_pagination';
    }
}
