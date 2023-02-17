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

use Countable;
use IteratorAggregate;

/**
 * Central abstraction for paginatable results.
 *
 * It allows iterating over the result either paginated using the {@link take}
 * method or non-paginated using the iterator aggregate API.
 */
interface Result extends Countable, IteratorAggregate
{
    /**
     * @param int $offset
     * @param int $limit
     * @return \Porpaginas\Page
     */
    public function take($offset, $limit);

    /**
     * Return the number of all results in the paginatable.

     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count();

    /**
     * Return an iterator over all results of the paginatable.
     *
     * @return \Iterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator();
}
