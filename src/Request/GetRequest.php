<?php

namespace MyobAdvanced\Request;

use MyobAdvanced\AbstractObject;
use MyobAdvanced\Traits\HasExpands;
use MyobAdvanced\Traits\HasSelects;

class GetRequest extends Request
{
    use HasSelects, HasExpands;

    public function __construct($class, $myobAdvanced, protected string $id)
    {
        return parent::__construct($class, $myobAdvanced);
    }

    public function getUri(): string
    {
        return parent::getUri() . '/' . $this->id;
    }

    protected function formatResponse(): AbstractObject
    {
        return new $this->class($this->response->object());
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