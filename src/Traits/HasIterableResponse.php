<?php

namespace MyobAdvanced\Traits;

use Illuminate\Support\Collection;
use MyobAdvanced\Request\Request;

trait HasIterableResponse
{
    protected Collection $results;

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->results->toArray());
    }

    public function offsetGet($offset): mixed
    {
        return $this->results->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->results->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->results->offsetUnset($offset);
    }

    public function offsetExists($offset): bool
    {
        return $this->results->offsetExists($offset);
    }

    public function shift($count = 1)
    {
        return $this->results->shift($count);
    }
}