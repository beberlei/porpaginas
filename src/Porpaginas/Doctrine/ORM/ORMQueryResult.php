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

use Porpaginas\Result;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

use ArrayIterator;

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
     * @var array
     */
    private $result;

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
     * @return \Porpaginas\Page
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
        $query->setFirstResult($offset)->setMaxResults($limit);

        return new ORMQueryPage(new Paginator($query, $this->fetchCollection));
    }

    /**
     * Return the number of all results in the paginatable.

     * @return int
     */
    public function count()
    {
        $this->loadQuery();

        return count($this->result);
    }

    /**
     * Return an iterator over all results of the paginatable.
     *
     * @return Iterator
     */
    public function getIterator()
    {
        $this->loadQuery();

        return new ArrayIterator($this->result);
    }

    private function loadQuery()
    {
        if ($this->result === null) {
            $this->result = $this->query->getResult();
        }
    }
}
