<?php

namespace MyobAdvanced;

use Carbon\Carbon;
use PHPUnit\Runner\Exception;

abstract class AbstractObject
{
    public string $endpoint = 'Default';
    public string $endpointVersion = '20.200.001';

    // The underlying object from the API
    public object $object;
    // A hash that is stored to determine if the entity has changed when save is called
    public string $hash;
    // If true this means the object already has an ID associated with it and any save will attempt to do a PUT request
    public bool $saved = false;

    public array $expands = [];

    protected array $dates = [
        'CreatedDateTime',
        'LastModifiedDateTime',
    ];

    public function __construct($object = null)
    {
        $this->object = new \stdClass();

        if ($object) {
            $this->loadObject(is_object($object) ? $object : json_decode($object, false));
            $this->saved = true;
        }

        $this->hash = $this->getHash();
    }

    public function loadObject($object)
    {
        $this->object = $object;
    }

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
        return $this->entity ?? class_basename($this);
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