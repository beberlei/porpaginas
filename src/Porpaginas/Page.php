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

namespace Porpaginas;

use IteratorAggregate;
use Countable;

/**
 * Interface for lazy paginators
 */
interface Page extends Countable, IteratorAggregate
{
    /**
     * @return int
     */
    public function getCurrentOffset();

    /**
     * @return int
     */
    public function getCurrentPage();

    /**
     * @return int
     */
    public function getCurrentLimit();

    /**
     * Return the number of results on the currrent page of the {@link Result}.
     *
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count();

    /**
     * Return the number of ALL results in the paginatable of {@link Result}.
     *
     * @return int
     */
    public function totalCount();

    /**
     * Return an iterator over selected windows of results of the paginatable.
     *
     * @return \Iterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator();
}
