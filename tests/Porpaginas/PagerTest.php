<?php

namespace Porpaginas;

use Porpaginas\Pager;
use Porpaginas\Arrays\ArrayPage;
use Porpaginas\Arrays\ArrayResult;

final class PagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_gets_number_of_pages()
    {
        $page = new ArrayPage(range(0, 19), 0, 20, 96);
        $pager = new Pager($page);
        $this->assertEquals(array(1, 2, 3, 4,), $pager->getPages());
    }

    /**
     * @test
     */
    public function it_handles_negative_page_numbers()
    {
        $page = new ArrayPage(range(0, 19), -42, 10, 95);
        $pager = new Pager($page);
        $this->assertEquals(array(1, 2, 3, 4,), $pager->getPages());
    }

    /**
     * @test
     */
    public function it_handles_too_big_page_numbers()
    {
        $pager = Pager::fromResult(new ArrayResult(range(0, 99)), 500, 10);
        $this->assertEquals(array(7, 8, 9, 10), $pager->getPages());
    }

    /**
     * @test
     */
    public function it_handles_empty_lists()
    {
        $pager = Pager::fromResult(new ArrayResult(array()), 5, 10);
        $this->assertEquals(array(1), $pager->getPages());
    }

    /**
     * @test
     */
    public function it_takes_a_page_given_a_page_number()
    {
        $pager = Pager::fromResult(new ArrayResult(range(0, 99)), 6, 10);
        $this->assertEquals(array(50, 51, 52, 53, 54, 55, 56, 57, 58, 59), iterator_to_array($pager));
    }
}
