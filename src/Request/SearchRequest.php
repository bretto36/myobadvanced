<?php

namespace MyobAdvanced\Request;

use ArrayAccess;
use Illuminate\Support\Collection;
use IteratorAggregate;
use MyobAdvanced\AbstractObject;
use MyobAdvanced\Traits\HasExpands;
use MyobAdvanced\Traits\HasFilters;
use MyobAdvanced\Traits\HasIterableResponse;
use MyobAdvanced\Traits\HasSelects;

class SearchRequest extends Request implements IteratorAggregate, ArrayAccess
{
    use HasFilters, HasSelects, HasExpands, HasIterableResponse;

    protected int $page = 1;
    protected int $pageSize = 1000;
    protected Collection $results;
    protected int $resultCount = 0;

    public function __construct($class, $myobAdvanced, $pageSize = null)
    {
        if (null !== $pageSize) {
            $this->pageSize = $pageSize;
        }

        $this->results = collect();

        parent::__construct($class, $myobAdvanced);
    }

    public function formatResponse(): AbstractObject|Collection
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

    public function next(): false|static
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

    public function setPage(int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function setPageSize(int $pageSize): static
    {
        $this->pageSize = $pageSize;

        return $this;
    }
}