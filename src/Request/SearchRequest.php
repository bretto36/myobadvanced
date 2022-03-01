<?php

namespace MyobAdvanced\Request;

use ArrayAccess;
use ArrayIterator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use IteratorAggregate;
use MyobAdvanced\AbstractObject;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCredentialsException;
use MyobAdvanced\Exception\UnauthorizedException;

class SearchRequest extends Request implements IteratorAggregate, ArrayAccess
{
    protected $filters = [];
    protected $selects = [];
    protected $expands = [];
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

    public function getData()
    {
        return $this->getQuery();
    }

    /**
     * @param $expands
     * @return $this
     */
    public function setExpands($expands): Request
    {
        $this->expands = $expands;

        return $this;
    }

    /**
     * @param $expand
     * @return $this
     */
    public function addExpand($expand): Request
    {
        if (!is_array($expand)) {
            $expand = [$expand];
        }

        foreach ($expand as $value) {
            $this->expands[$value] = $value;
        }

        return $this;
    }

    /**
     * @param $selects
     * @return $this
     */
    public function setSelects($selects): Request
    {
        $this->selects = $selects;

        return $this;
    }

    /**
     * @param $select
     * @return $this
     */
    public function addSelect($select): Request
    {
        $this->selects[$select] = $select;

        return $this;
    }

    /**
     * @param $filters
     * @return $this
     */
    public function setFilters($filters): Request
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param $field
     * @param $operation
     * @param null $value
     * @return $this
     */
    public function addFilter($field, $operation, $value = null): Request
    {
        if (null === $value) {
            $value     = $operation;
            $operation = 'eq';
        }

        if (is_string($value)) {
            $value = '\'' . $value . '\'';
        } else if (is_a($value, Carbon::class)) {
            $value = 'datetimeoffset\'' . $value->format('Y-m-d\TH:i:s') . '\'';
        }

        $this->filters[] = $field . ' ' . $operation . ' ' . $value;

        return $this;
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
     * @throws ApiException
     * @throws InvalidCredentialsException
     * @throws UnauthorizedException
     */
    public function next()
    {
        if (!$this->resultCount > 0 || $this->resultCount <= $this->pageSize) {
            return false;
        }

        $this->page++;

        $this->send();

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
            $values['$filter'] = implode(' AND ', $this->filters);
        }

        // Paginate
        $values['$top']    = $this->pageSize;
        $values['$offset'] = ($this->page - 1) * $this->pageSize;

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