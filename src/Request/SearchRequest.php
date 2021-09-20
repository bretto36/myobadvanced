<?php

namespace MyobAdvanced\Request;

use Illuminate\Support\Collection;

class SearchRequest extends GetRequest implements \IteratorAggregate, \ArrayAccess
{
    protected array $filters = [];
    protected int $page = 1;
    protected int $pageSize = 1000;
    protected Collection $results;
    protected int $resultCount = 0;

    public function __construct($className, $myobAdvanced, $pageSize = null)
    {
        if (null !== $pageSize) {
            $this->pageSize = $pageSize;
        }

        $this->results = collect();

        parent::__construct($className, $myobAdvanced);
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
        }

        $this->filters[] = $field . ' ' . $operation . ' ' . $value;

        return $this;
    }

    public function formatResponse(): \MyobAdvanced\AbstractObject|\Illuminate\Support\Collection
    {
        $this->results = collect();
        foreach ($this->response->object() as $object) {
            $this->results->push(new $this->className($object));
        }

        $this->resultCount = $this->results->count();

        return $this->results;
    }

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
        return new \ArrayIterator($this->results->toArray());
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