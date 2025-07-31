<?php

namespace MyobAdvanced\Request;

use ArrayAccess;
use Illuminate\Support\Collection;
use IteratorAggregate;
use MyobAdvanced\AbstractObject;
use MyobAdvanced\Traits\HasExpands;
use MyobAdvanced\Traits\HasIterableResponse;
use MyobAdvanced\Traits\HasSelects;

class InquiryRequest extends Request implements IteratorAggregate, ArrayAccess
{
    use HasSelects, HasExpands, HasIterableResponse;

    protected string $method = 'PUT';
    protected $requestObject;
    protected int $resultCount = 0;
    protected string $rootElement = 'Results';

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

    public function formatResponse(): AbstractObject|Collection
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
}