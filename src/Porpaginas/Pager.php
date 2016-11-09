<?php

namespace Porpaginas;

final class Pager implements \IteratorAggregate
{
    private $totalCount;
    private $limit;
    private $currentPageNumber;
    private $page;

    public function __construct(Page $page)
    {
        $this->totalCount = $page->totalCount();
        $this->limit = $page->getCurrentLimit();
        $this->currentPageNumber = max(1, $page->getCurrentPage());
        $this->page = $page;
    }

    public static function fromResult(Result $result, $page, $numberPerPage)
    {
        $limit = max(0, $numberPerPage);
        $offset = max(0, ($page - 1) * $limit);

        return new self($result->take($offset, $limit));
    }

    public function getIterator()
    {
        return $this->page;
    }

    public function isCurrent($page)
    {
        return $this->currentPageNumber === $page;
    }

    public function getPages($siblings = 3)
    {
        return range($this->getSliceStart($siblings), $this->getSliceEnd($siblings));
    }

    public function getNumberOfPages()
    {
        return (int)ceil($this->totalCount / $this->limit) ?: 1;
    }

    private function getSliceStart($siblings)
    {
        return min(
            max(1, $this->getNumberOfPages() - $siblings),
            max(1, $this->currentPageNumber - $siblings)
        );
    }

    private function getSliceEnd($siblings)
    {
        return max(1, min($this->getNumberOfPages(), $this->currentPageNumber + $siblings));
    }
}
