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

namespace Porpaginas\Arrays;

use Porpaginas\Result;
use ArrayIterator;

class ArrayResult implements Result
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int $offset
     * @return \Porpaginas\Page
     */
    public function take($offset, $limit)
    {
        return new ArrayPage(
            array_slice($this->data, $offset, $limit),
            $offset,
            $limit,
            count($this->data)
        );
    }

    /**
     * Return the number of all results in the paginatable.

     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->data);
    }

    /**
     * Return an iterator over all results of the paginatable.
     *
     * @return Iterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}
