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

namespace Porpaginas\Doctrine\ORM;

use Porpaginas\Page;
use Doctrine\ORM\Tools\Pagination\Paginator;
use ArrayIterator;

/**
 * @template T of object
 * @implements Page<T>
 */
class ORMQueryPage implements Page
{
    /**
     * @var \Doctrine\ORM\Tools\Pagination\Paginator<T>
     */
    private $paginator;

    /**
     * @var list<T>|null
     */
    private $result;

    /**
     * @param Paginator<T> $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @return int
     */
    public function getCurrentOffset()
    {
        return $this->paginator->getQuery()->getFirstResult();
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return (int) floor($this->getCurrentOffset() / $this->getCurrentLimit()) + 1;
    }

    /**
     * @return int
     */
    public function getCurrentLimit()
    {
        return $this->paginator->getQuery()->getMaxResults();
    }

    /**
     * Return the number of results on the currrent page of the {@link Result}.
     *
     * @return int
     */
    public function count()
    {
        if ($this->result === null) {
            /** @var list<T> $result */
            $result = iterator_to_array($this->paginator);
            $this->result = $result;
        }

        return count($this->result);
    }

    /**
     * Return the number of ALL results in the paginatable of {@link Result}.
     *
     * @return int
     */
    public function totalCount()
    {
        return $this->paginator->count();
    }

    /**
     * Return an iterator over selected windows of results of the paginatable.
     *
     * @return \Traversable<int, T>
     */
    public function getIterator()
    {
        if ($this->result) {
            return new ArrayIterator($this->result);
        }

        /** @var \Traversable<int, T> $paginator */
        $paginator = $this->paginator;

        return $paginator;
    }
}
