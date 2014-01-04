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

use Porpaginas\Page;

class ArrayPage implements Page
{
    private $slice;
    private $offset;
    private $limit;
    private $totalCount;

    public function __construct(array $slice, $offset, $limit, $totalCount)
    {
        $this->slice = $slice;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->totalCount = $totalCount;
    }

    /**
     * @return int
     */
    public function getCurrentOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return floor($this->offset / $this->limit) + 1;
    }

    /**
     * @return int
     */
    public function getCurrentLimit()
    {
        return $this->limit;
    }

    /**
     * Return the number of results on the currrent page of the {@link Result}.
     *
     * @return int
     */
    public function count()
    {
        return count($this->slice);
    }

    /**
     * Return the number of ALL results in the paginatable of {@link Result}.
     *
     * @return int
     */
    public function totalCount()
    {
        return $this->totalCount;
    }

    /**
     * Return an iterator over selected windows of results of the paginatable.
     *
     * @return Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->slice);
    }
}
