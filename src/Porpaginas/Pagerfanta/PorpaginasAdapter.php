<?php

namespace Porpaginas\Pagerfanta;

use Pagerfanta\Adapter\AdapterInterface;
use Porpaginas\Page;
use Porpaginas\Result;

/**
 * @template T
 * @implements AdapterInterface<T>
 */
class PorpaginasAdapter implements AdapterInterface
{
    /** @var Result<T>|Page<T> */
    private $result;

    /** @param Result<T>|Page<T> $result */
    public function __construct(Result|Page $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the number of results.
     *
     * @return int The number of results.
     */
    public function getNbResults(): int
    {
        if ($this->result instanceof Page) {
            return $this->result->totalCount();
        }

        return $this->result->take(0, 1)->totalCount();
    }

    /**
     * Returns an slice of the results.
     *
     * @param int $offset The offset.
     * @param int $length The length.
     *
     * @return iterable<array-key, T> The slice.
     */
    public function getSlice(int $offset, int $length): iterable
    {
        if ($this->result instanceof Page) {
            return iterator_to_array($this->result);
        }

        return iterator_to_array($this->result->take($offset, $length));
    }
}
