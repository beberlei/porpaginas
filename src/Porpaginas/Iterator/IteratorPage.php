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

namespace Porpaginas\Iterator;

use Porpaginas\Page;

class IteratorPage implements Page
{
    /**
     * @var \Iterator
     */
    private $iterator;
    
    /**
     * @var int
     */
    private $offset;
    
    /**
     * @var int
     */
    private $limit;
    
    /**
     * @var int
     */
    private $totalCount;

    /**
     * @param \Iterator $iterator
     * @param int $offset
     * @param int $limit
     * @param int $totalCount
     */
    public function __construct(\Iterator $iterator, $offset, $limit, $totalCount)
    {
        $this->iterator = $iterator;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->totalCount = $totalCount;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentOffset()
    {
        return $this->offset;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        if (0 === $this->limit) {
            return 1;
        }

        return floor($this->offset / $this->limit) + 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function totalCount()
    {
        return $this->totalCount;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->iterator;
    }
}
