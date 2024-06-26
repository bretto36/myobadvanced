<?php

namespace MyobAdvanced\Request;

use ArrayAccess;
use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;
use MyobAdvanced\AbstractObject;
use MyobAdvanced\Traits\HasExpands;
use MyobAdvanced\Traits\HasFilters;
use MyobAdvanced\Traits\HasSelects;

class SearchRequest extends Request implements IteratorAggregate, ArrayAccess
{
    use HasFilters, HasSelects, HasExpands;

    protected $page = 1;
    protected $pageSize = 1000;
    /** @var Collection */
    protected $results;
    protected $resultCount = 0;

    public function __construct($class, $myobAdvanced, $pageSize = null)
    {
        if (null !== $pageSize) {
            $this->pageSize = $pageSize;
        }

        $this->results = collect();

        parent::__construct($class, $myobAdvanced);
    }

    /**
     * @return AbstractObject|Collection
     */
    public function formatResponse()
    {
        $this->results = collect();
        foreach ($this->response->object() as $object) {
            $class = clone $this->class;

            $class->loadObject($object);

            $this->results->push($class);
        }

        $this->resultCount = $this->results->count();

        return $this->results;
    }

    /**
     * @return $this|false
     */
    public function next()
    {
        // If the number of results is less than the page size then we have to have reached the last page
        if ($this->resultCount < $this->pageSize) {
            return false;
        }

        $this->page++;

        return $this;
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

        // Filter
        if (!empty($this->filters)) {
            $values['$filter'] = implode(' and ', $this->filters);
        }

        // Paginate
        $values['$top']  = $this->pageSize;
        $values['$skip'] = ($this->page - 1) * $this->pageSize;

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

    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
    }
}