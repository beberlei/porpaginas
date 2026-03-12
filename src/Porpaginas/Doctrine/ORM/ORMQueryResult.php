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

use Porpaginas\Arrays\ArrayPage;
use Porpaginas\Result;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

use ArrayIterator;

/**
 * @template T of object
 * @implements Result<T>
 */
class ORMQueryResult implements Result
{
    /**
     * @var \Doctrine\ORM\Query
     */
    private $query;

    /**
     * @var bool
     */
    private $fetchCollection;

    /**
     * @var list<T>|null
     */
    private $result;

    /**
     * @var int|null
     */
    private $count;

    public function __construct($query, $fetchCollection = true)
    {
        if ($query instanceof QueryBuilder) {
            $query = $query->getQuery();
        }

        $this->query = $query;
        $this->fetchCollection = $fetchCollection;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return \Porpaginas\Page<T>
     */
    public function take($offset, $limit)
    {
        if ($this->result !== null) {
            return new ArrayPage(
                array_slice($this->result, $offset, $limit),
                $offset,
                $limit,
                count($this->result)
            );
        }

        $query = clone $this->query;
        $query->setParameters($this->query->getParameters());
        foreach ($this->query->getHints() as $name => $value) {
            $query->setHint($name, $value);
        }

        $query->setFirstResult($offset)->setMaxResults($limit);

        /** @var \Doctrine\ORM\Tools\Pagination\Paginator<T> $paginator */
        $paginator = new Paginator($query, $this->fetchCollection);

        return new ORMQueryPage($paginator);
    }

    /**
     * Return the number of all results in the paginatable.
     *
     * @return int
     */
    public function count()
    {
        if ($this->count === null) {
            $this->count = count(new Paginator($this->query, $this->fetchCollection));
        }

        return $this->count;
    }

    /**
     * Return an iterator over all results of the paginatable.
     *
     * @return \ArrayIterator<int, T>
     */
    public function getIterator()
    {
        if ($this->result === null) {
            /** @var list<T> $result */
            $result = $this->query->getResult();
            $this->result = $result;
            $this->count = count($this->result);
        }

        return new ArrayIterator($this->result);
    }
}
