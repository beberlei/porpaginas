<?php

namespace Porpaginas;

use Porpaginas\Pager;

final class PagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_gets_number_of_pages()
    {
        $pager = new Pager(95, 20, 1);
        $this->assertEquals($pager->getPages(), array(1, 2, 3, 4,));
    }

    /**
     * @test
     */
    public function it_handles_negative_page_numbers()
    {
        $pager = new Pager(95, 10, -42);
        $this->assertEquals($pager->getPages(), array(1, 2, 3, 4,));
    }

    /**
     * @test
     */
    public function it_handles_too_big_page_numbers()
    {
        $pager = new Pager(95, 10, 42);
        $this->assertEquals($pager->getPages(), array(7, 8, 9, 10));
    }

    /**
     * @test
     */
    public function it_handles_empty_lists()
    {
        $pager = new Pager(0, 10, 42);
        $this->assertEquals($pager->getPages(), array(1));
    }
}
