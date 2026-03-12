<?php

namespace Porpaginas\Twig;

use Porpaginas\Page;
use Twig\Environment;
use Knp\Component\Pager\Paginator;

class KnpPagerRenderingAdapter implements RenderingAdapter
{
    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var string|null
     */
    private $template;

    /**
     * @param string|null $template
     */
    public function __construct(Paginator $paginator, $template = null)
    {
        $this->paginator = $paginator;
        $this->template = $template;
    }

    /**
     * @param Page<mixed> $page
     * @return string
     */
    public function renderPagination(Page $page, Environment $environment)
    {
        $method = new \ReflectionMethod($environment, 'getExtension');
        $extension = $method->invoke($environment, 'knp_pagination');

        return $extension->render(
            $this->paginator->paginate(
                $page,
                $page->getCurrentPage(),
                $page->getCurrentLimit()
            ),
            $this->template
        );
    }
}
