<?php

namespace Porpaginas;

use Porpaginas\Arrays\ArrayResult;

class ArrayTest extends AbstractResultTestCase
{
    /** @return Result<string> */
    protected function createResultWithItems(int $count): Result
    {
        return new ArrayResult(array_fill(0, $count, 'value'));
    }
}
