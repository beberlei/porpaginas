<?php

namespace Porpaginas\Twig;

use Porpaginas\Page;
use Twig_Environment;
use Knp\Component\Pager\Paginator;

class KnpPagerRenderingAdapter implements RenderingAdapter
{
    private $paginator;
    private $template;

    public function __construct(Paginator $paginator, $template = null)
    {
        $this->paginator = $paginator;
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function renderPagination(Page $page, Twig_Environment $environment)
    {
        return $environment->getExtension('knp_pagination')->render(
            $this->paginator->paginate(
                $page,
                $page->getCurrentPage(),
                $page->getCurrentLimit()
            ),
            $this->template
        );
    }
}
