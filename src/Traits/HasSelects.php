<?php

namespace MyobAdvanced\Traits;

trait HasSelects
{
    protected $selects = [];

    public function setSelects($selects): self
    {
        $this->selects = $selects;

        return $this;
    }

    public function addSelect($select): self
    {
        $this->selects[$select] = $select;

        return $this;
    }
}