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

use Porpaginas\Page;
use Twig\Extension;
use Twig\Environment;
use Twig\TwigFunction;

class PorpaginasExtension extends Extension\AbstractExtension
{
    /** @var RenderingAdapter */
    private $adapter;

    public function __construct(RenderingAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /** @return array<int, TwigFunction> */
    public function getFunctions()
    {
        return [
            new TwigFunction('porpaginas_render', [$this, 'renderPagination'], ['is_safe' => ['html'], 'needs_environment' => true]),
            new TwigFunction('porpaginas_total', [$this, 'renderTotal']),
        ];
    }

    /**
     * @param Page<mixed> $page
     * @return string
     */
    public function renderPagination(Environment $environment, Page $page)
    {
        return $this->adapter->renderPagination($page, $environment);
    }

    /**
     * @param Page<mixed> $page
     * @return int
     */
    public function renderTotal(Page $page)
    {
        return $page->totalCount();
    }

    /** @return string */
    public function getName()
    {
        return 'Porpaginas';
    }
}
