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
use Twig\Environment;

interface RenderingAdapter
{
    /**
     * @return string
     */
    public function renderPagination(Page $page, Environment $environment);
}
