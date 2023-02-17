<?php

namespace Porpaginas\Pagerfanta;

use Porpaginas\Arrays\ArrayResult;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;

class PorpaginasAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_counts_total_number_of_results()
    {
        $pagerfanta = new Pagerfanta(
            new PorpaginasAdapter(
                new ArrayResult(array(1, 2, 3, 4))
            )
        );

        $this->assertEquals(4, $pagerfanta->getNbResults());
    }

    /**
     * @test
     */
    public function it_iterates_slice()
    {
        $pagerfanta = new Pagerfanta(
            new PorpaginasAdapter(
                new ArrayResult(array(1, 2, 3, 4))
            )
        );

        $pagerfanta->setMaxPerPage(2);
        $pagerfanta->setCurrentPage(1);

        $this->assertEquals(array(1, 2), $pagerfanta->getCurrentPageResults());

        $pagerfanta->setCurrentPage(2);

        $this->assertEquals(array(3, 4), $pagerfanta->getCurrentPageResults());
    }
}
