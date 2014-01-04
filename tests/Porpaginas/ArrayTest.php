<?php

namespace Porpaginas;

use Porpaginas\Arrays\ArrayResult;

class ArrayTest extends AbstractResultTestCase
{
    protected function createResultWithItems($count)
    {
        return new ArrayResult(array_fill(0, $count, 'value'));
    }
}
