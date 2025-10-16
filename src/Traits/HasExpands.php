<?php

namespace MyobAdvanced\Traits;

use MyobAdvanced\Request\GetRequest;
use MyobAdvanced\Request\InquiryRequest;
use MyobAdvanced\Request\SearchRequest;

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
     * @return InquiryRequest|GetRequest|SearchRequest|HasExpands
     */
    public function addExpand($expand): self
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