<?php

namespace MyobAdvanced;

use Carbon\Carbon;
use PHPUnit\Runner\Exception;

abstract class AbstractObject
{
    public string $entity = ''; // This should be overridden per object
    public string $endpoint = 'Default';
    public string $endpointVersion = '20.200.001';

    public object $object;
    public string $hash;
    public bool $saved = false;

    protected array $dates = [];

    public function getId()
    {
        return $this->object->id ?? null;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getEndpointVersion(): string
    {
        return $this->endpointVersion;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function __construct($object = null)
    {
        if (is_object($object)) {
            $this->object = $object;
            $this->saved  = true;
        } elseif ($object) {
            $this->object = json_decode($object, false);
            $this->saved  = true;
        } else {
            $this->object = new \stdClass();
        }

        $this->hash = $this->getHash();
    }

    public function getHash(): string
    {
        return sha1(json_encode($this->object));
    }

    public function isDirty(): bool
    {
        return ($this->getHash() != $this->hash);
    }

    public function isSaved()
    {
        return $this->saved;
    }

    public function save()
    {
        // Check for ID
        if ($this->isSaved()) {
            if (!$this->isDirty()) {
                return true;
            }

            // Put request to save
            $result = false;

            return $result;
        }

        // Post Request
        return true;
    }

    public function get($field, $default)
    {
        $value = $this->object->$field->value ?? $default;

        // Format to Carbon Date
        if (in_array($field, $this->dates)) {
            $value = Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $value);
        }

        return $value;
    }

    public function set($field, $value)
    {
        if (is_a($value, Carbon::class)) {
            $value = $value->format('Y-m-d\TH:i:s');
        }

        $this->object->$field->value = $value;

        return $this;
    }

    public function has($field)
    {
        return (isset($this->object->$field->value) && null !== $this->object->$field->value);
    }

    public function is($field)
    {
        return (isset($this->object->$field->value) && $this->object->$field->value);
    }

    public function __call($name, $arguments)
    {
        if (preg_match('/(get|set|has|is)(.*)/', $name, $matches)) {
            switch ($matches[1]) {
                case 'get':
                case 'set':
                    return $this->{$matches[1]}($matches[2], ($arguments[0] ?? null));
                case 'has':
                case 'is':
                    return $this->{$matches[1]}($matches[2]);
            }
        }

        throw new Exception('Method does not exist: ' . $name . ' for class: ' . self::class);
    }
}