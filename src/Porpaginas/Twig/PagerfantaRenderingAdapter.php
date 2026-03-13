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

use Pagerfanta\Pagerfanta;
use Porpaginas\Page;
use Porpaginas\Pagerfanta\PorpaginasAdapter;
use Twig\Environment;

class PagerfantaRenderingAdapter implements RenderingAdapter
{
    /** @var string|null */
    private $viewName;

    /** @var array<array-key, mixed> */
    private $options;

    /**
     * @param string|null             $viewName
     * @param array<array-key, mixed> $options
     */
    public function __construct($viewName = null, $options = [])
    {
        $this->viewName = $viewName;
        $this->options = $options;
    }

    /**
     * @param Page<mixed> $page
     * @return string
     */
    public function renderPagination(Page $page, Environment $environment)
    {
        $pagerfanta = new Pagerfanta(new PorpaginasAdapter($page));
        $pagerfanta->setCurrentPage($page->getCurrentPage());
        $pagerfanta->setMaxPerPage($page->getCurrentLimit());

        $method = new \ReflectionMethod($environment, 'getExtension');
        $extension = $method->invoke($environment, 'pagerfanta');

        return $extension->renderPagerfanta(
            $pagerfanta,
            $this->viewName,
            $this->options,
        );
    }
}
