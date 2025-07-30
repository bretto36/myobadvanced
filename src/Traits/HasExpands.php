<?php

namespace MyobAdvanced\Traits;

use MyobAdvanced\Request\Request;

trait HasExpands
{
    protected array $expands = [];

    public function setExpands($expands): self
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
            if (!in_array($value, $this->expands)) {
                $this->expands[] = $value;
            }
        }

        return $this;
    }

    public function getExpands(): array
    {
        return $this->expands;
    }
}