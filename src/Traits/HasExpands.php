<?php

namespace MyobAdvanced\Traits;

trait HasExpands
{
    protected $expands = [];

    public function setExpands($expands): self
    {
        $this->expands = $expands;

        return $this;
    }

    public function addExpand($expand): self
    {
        if (!is_array($expand)) {
            $expand = [$expand];
        }

        foreach ($expand as $value) {
            $this->expands[$value] = $value;
        }

        return $this;
    }

}