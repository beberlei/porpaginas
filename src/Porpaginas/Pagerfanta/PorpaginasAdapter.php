<?php

namespace Porpaginas\Pagerfanta;

use Pagerfanta\Adapter\AdapterInterface;
use Porpaginas\Result;

class PorpaginasAdapter implements AdapterInterface
{
    private $result;

    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    function getNbResults()
    {
        return $this->result->take(0, 1)->totalCount();
    }

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return array|\Traversable The slice.
     */
    function getSlice($offset, $length)
    {
        return iterator_to_array($this->result->take($offset, $length));
    }
}
