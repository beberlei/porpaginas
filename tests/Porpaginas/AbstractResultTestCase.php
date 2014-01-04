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

    /**
     * @test
     */
    public function it_takes_slice_as_page()
    {
        $result = $this->createResultWithItems(11);

        $page = $result->take(0, 10);

        $this->assertEquals(1, $page->getCurrentPage());
        $this->assertEquals(0, $page->getCurrentOffset());
        $this->assertEquals(10, $page->getCurrentLimit());
        $this->assertCount(10, $page);
        $this->assertEquals(11, $page->totalCount());
    }

    /**
     * @test
     */
    public function it_counts_last_page_of_slice_correctly()
    {
        $result = $this->createResultWithItems(11);

        $page = $result->take(10, 10);

        $this->assertEquals(2, $page->getCurrentPage());
        $this->assertEquals(10, $page->getCurrentOffset());
        $this->assertEquals(10, $page->getCurrentLimit());
        $this->assertCount(1, $page);
    }

    /**
     * @test
     */
    public function it_counts_page_first_then_iterates()
    {
        $result = $this->createResultWithItems(16);

        $page = $result->take(10, 5);

        $this->assertCount(5, $page);
        $this->assertCount(5, iterator_to_array($page));
    }

    /**
     * @test
     */
    public function it_itereates_first_then_counts_page()
    {
        $result = $this->createResultWithItems(16);

        $page = $result->take(10, 5);

        $this->assertCount(5, iterator_to_array($page));
        $this->assertCount(5, $page);
    }

    abstract protected function createResultWithItems($count);
}
