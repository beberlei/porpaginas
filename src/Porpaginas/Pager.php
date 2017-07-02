<?php

namespace Porpaginas;

final class Pager
{
    private $totalCount;
    private $limit;
    private $currentPage;

    public function __construct($totalCount, $limit, $currentPage)
    {
        $this->totalCount = $totalCount;
        $this->limit = $limit;
        $this->currentPage = max(1, $currentPage);
    }

    public static function fromPage(Page $page)
    {
        return new self($page->totalCount(), $page->getCurrentLimit(), $page->getCurrentPage());
    }

    public function isCurrent($page)
    {
        return $this->currentPage === $page;
    }

    public function getPages($siblings = 3)
    {
        return range($this->getSliceStart($siblings), $this->getSliceEnd($siblings));
    }

    public function getNumberOfPages()
    {
        return (int) ceil($this->totalCount / $this->limit) ?: 1;
    }

    private function getSliceStart($siblings)
    {
        return min(
            max(1, $this->getNumberOfPages() - $siblings),
            max(1, $this->currentPage - $siblings)
        );
    }

    private function getSliceEnd($siblings)
    {
        return max(1, min($this->getNumberOfPages(), $this->currentPage + $siblings));
    }
}
