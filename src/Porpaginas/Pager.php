<?php

namespace Porpaginas;

final class Pager
{
    /** @var int */
    private $totalCount;

    /** @var int */
    private $limit;

    /** @var int */
    private $currentPage;

    /**
     * @param int $totalCount
     * @param int $limit
     * @param int $currentPage
     */
    public function __construct($totalCount, $limit, $currentPage)
    {
        $this->totalCount = $totalCount;
        $this->limit = $limit;
        $this->currentPage = max(1, $currentPage);
    }

    /**
     * @param Page<mixed> $page
     * @return self
     */
    public static function fromPage(Page $page)
    {
        return new self($page->totalCount(), $page->getCurrentLimit(), $page->getCurrentPage());
    }

    /**
     * @param int $page
     * @return bool
     */
    public function isCurrent($page)
    {
        return $this->currentPage === $page;
    }

    /**
     * @param int $siblings
     * @return list<int>
     */
    public function getPages($siblings = 3)
    {
        return range($this->getSliceStart($siblings), $this->getSliceEnd($siblings));
    }

    /** @return int */
    public function getNumberOfPages()
    {
        return (int) ceil($this->totalCount / $this->limit) ?: 1;
    }

    /**
     * @param int $siblings
     * @return int
     */
    private function getSliceStart($siblings)
    {
        return min(
            max(1, $this->getNumberOfPages() - $siblings),
            max(1, $this->currentPage - $siblings),
        );
    }

    /**
     * @param int $siblings
     * @return int
     */
    private function getSliceEnd($siblings)
    {
        return max(1, min($this->getNumberOfPages(), $this->currentPage + $siblings));
    }
}
