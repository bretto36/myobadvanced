<?php

namespace MyobAdvanced\Request;

use MyobAdvanced\AbstractObject;

class GetRequest extends Request
{
    protected string|int $id;

    protected array $selects = [];
    protected array $expands = [];

    public function __construct($className, $myobAdvanced, $id)
    {
        $this->id = $id;

        return parent::__construct($className, $myobAdvanced);
    }

    public function getData()
    {
        return $this->getQuery();
    }

    public function getUri()
    {
        return parent::getUri() . '/' . $this->id;
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
     * @return AbstractObject
     */
    protected function formatResponse()
    {
        return new $this->className($this->response->object());
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