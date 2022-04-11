<?php

namespace MyobAdvanced\Request;

use ArrayAccess;
use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;
use MyobAdvanced\AbstractObject;
use MyobAdvanced\Traits\HasExpands;
use MyobAdvanced\Traits\HasSelects;

class InquiryRequest extends Request implements IteratorAggregate, ArrayAccess
{
    use HasSelects, HasExpands;

    protected $method = 'PUT';
    protected $requestObject;
    /** @var Collection */
    protected $results;
    protected $resultCount = 0;
    protected $rootElement = 'Results';

    public function __construct($class, $myobAdvanced, $requestObject = null)
    {
        $this->expands       = ['Results'];
        $this->requestObject = $requestObject ?: ['blankObject' => true];

        $this->results = collect();

        parent::__construct($class, $myobAdvanced);
    }

    public function getBody()
    {
        return $this->requestObject;
    }

    /**
     * @return AbstractObject|Collection
     */
    public function formatResponse()
    {
        $this->results = collect();

        foreach ($this->response->object()->{$this->rootElement} as $object) {
            $class = clone $this->class;

            $class->loadObject($object);

            $this->results->push($class);
        }

        $this->resultCount = $this->results->count();

        return $this->results;
    }

    public function getQuery(): array
    {
        $values = parent::getQuery();

        // Selects
        if (!empty($this->selects)) {
            $values['$select'] = implode(',', $this->selects);
        }

        // Expands
        if (!empty($this->expands)) {
            $values['$expand'] = implode(',', $this->expands);
        }

        return $values;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->results->toArray());
    }

    public function offsetGet($offset)
    {
        return $this->results->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->results->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->results->offsetUnset($offset);
    }

    public function offsetExists($offset)
    {
        $this->results->offsetExists($offset);
    }

    public function shift($count = 1)
    {
        return $this->results->shift($count);
    }
}