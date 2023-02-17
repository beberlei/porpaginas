<?php

namespace Porpaginas\Twig;
use PHPUnit\Framework\TestCase;

class PorpaginasExtensionTest extends TestCase
{
    /**
     * @test
     */
    public function it_delegates_render_pagination_to_adapter()
    {
        $env = \Phake::mock('Twig\Environment');
        $page = \Phake::mock('Porpaginas\Page');
        $adapter = \Phake::mock('Porpaginas\Twig\RenderingAdapter');

        $extension = new PorpaginasExtension($adapter);

        $extension->renderPagination($env, $page);

        \Phake::verify($adapter)->renderPagination($page, $env);
    }
}
