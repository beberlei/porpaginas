<?php
/**
 * Porpaginas
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace Porpaginas\Twig;

use Pagerfanta\Adapter\CallbackAdapter;
use Pagerfanta\Pagerfanta;
use Porpaginas\Page;
use Twig_Environment;

class PagerfantaRenderingAdapter implements RenderingAdapter
{
    /**
     * @var string
     */
    private $viewName;

    /**
     * @var array
     */
    private $options;

    public function __construct($viewName = null, $options = array())
    {
        $this->viewName = $viewName;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function renderPagination(Page $page, Twig_Environment $environment)
    {
        $pagerfanta = new Pagerfanta(new CallbackAdapter(
            function () use ($page) {
                return $page->totalCount();
            },
            function () use ($page) {
                return iterator_to_array($page->getIterator());
            }
        ));
        $pagerfanta->setCurrentPage($page->getCurrentPage());
        $pagerfanta->setMaxPerPage($page->getCurrentLimit());

        return $environment->getExtension('pagerfanta')->renderPagerfanta(
            $pagerfanta, $this->viewName, $this->options
        );
    }
}
