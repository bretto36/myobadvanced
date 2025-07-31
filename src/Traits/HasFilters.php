<?php

namespace MyobAdvanced\Traits;

use Illuminate\Support\Carbon;

trait HasFilters
{
    protected array $filters = [];

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

        $this->filters[] = $this->makeFilter($field, $operation, $value);

        return $this;
    }

    public function makeFilter($field, $operation, $value): string
    {
        if (is_string($value)) {
            $value = '\'' . $value . '\'';
        } elseif (is_a($value, Carbon::class)) {
            $value = 'datetimeoffset\'' . $value->format('Y-m-d\TH:i:s') . '\'';
        } elseif (is_array($value) && in_array($operation, ['in', 'not in'])) {
            return '(' . implode($operation == 'in' ? ' or ' : ' and ', collect($value)
                    ->map(function ($item) use ($field, $operation) {
                        return $this->makeFilter($field, $operation == 'in' ? 'eq' : 'ne', $item);
                    })
                    ->toArray()) . ')';
        }

        return $field . ' ' . $operation . ' ' . $value;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }
}