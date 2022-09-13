<?php

namespace Util;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Internal\TentativeType;

class AbstractCollection implements IteratorAggregate, Countable
{
    protected array $collection = [];

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->collection);
    }

    protected function add(mixed $item)
    {
        $this->collection[] = $item;
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function first(): mixed
    {
        $collection = $this->collection;
        return array_shift($collection);
    }
}