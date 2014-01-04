<?php

namespace Porpaginas\Twig;

class PorpaginasExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_delegates_render_pagination_to_adapter()
    {
        $env = \Phake::mock('Twig_Environment');
        $page = \Phake::mock('Porpaginas\Page');
        $adapter = \Phake::mock('Porpaginas\Twig\RenderingAdapter');

        $extension = new PorpaginasExtension($adapter);
        $extension->initRuntime($env);

        $extension->renderPagination($page);

        \Phake::verify($adapter)->renderPagination($page, $env);
    }
}
