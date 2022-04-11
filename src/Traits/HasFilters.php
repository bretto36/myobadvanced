<?php

namespace MyobAdvanced\Traits;

use Illuminate\Support\Carbon;

trait HasFilters
{
    protected $filters = [];

    public function setFilters($filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function addFilter($field, $operation, $value = null): self
    {
        if (null === $value) {
            $value     = $operation;
            $operation = 'eq';
        }

        if (is_string($value)) {
            $value = '\'' . $value . '\'';
        } elseif (is_a($value, Carbon::class)) {
            $value = 'datetimeoffset\'' . $value->format('Y-m-d\TH:i:s') . '\'';
        }

        $this->filters[] = $field . ' ' . $operation . ' ' . $value;

        return $this;
    }
}