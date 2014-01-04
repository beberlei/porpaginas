<?php

namespace Porpaginas;

abstract class AbstractResultTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_counts_total_items()
    {
        $result = $this->createResultWithItems(2);

        $this->assertCount(2, $result);
    }

    /**
     * @test
     */
    public function it_iterates_over_all_items()
    {
        $result = $this->createResultWithItems(11);

        $this->assertCount(11, iterator_to_array($result));
    }

    abstract protected function createResultWithItems($count);
}
