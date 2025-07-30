<?php

namespace MyobAdvanced\Traits;

trait HasSelects
{
    protected array $selects = [];

    public function setSelects($selects): self
    {
        $this->selects = $selects;

        return $this;
    }

    public function addSelect($select): self
    {
        if (!in_array($select, $this->selects)) {
            $this->selects[] = $select;
        }

        return $this;
    }

    public function getSelects(): array
    {
        return $this->selects;
    }
}