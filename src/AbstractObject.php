<?php

namespace MyobAdvanced;

use Carbon\Carbon;
use PHPUnit\Runner\Exception;
use stdClass;

abstract class AbstractObject
{
    public $endpoint = 'Default';
    public $endpointVersion = '20.200.001';

    // The underlying object from the API
    public $object;
    // A hash that is stored to determine if the entity has changed when save is called
    public $hash;
    // If true this means the object already has an ID associated with it and any save will attempt to do a PUT request
    public $saved = false;

    public $expands = [];

    protected $dates = [
        'CreatedDateTime',
        'LastModifiedDateTime',
    ];

    public function __construct($object = null)
    {
        $this->object = new stdClass();

        if ($object) {
            $this->loadObject(is_object($object) ? $object : json_decode($object, false));
            $this->saved = true;
        }

        $this->hash = $this->getHash();
    }

    public function loadObject($object)
    {
        $this->object = $object;

        foreach ($this->expands as $key => $type) {
            if (isset($this->object->$key)) {
                if (is_array($type)) {
                    $this->$key = collect();

                    // Only set the value if it's an array
                    if (!is_array($this->object->$key)) {
                        continue;
                    }

                    $type = array_shift($type);

                    foreach ($this->object->$key as $subObject) {
                        $this->$key->push(new $type($subObject));
                    }
                } else {
                    $this->$key = new $type($this->object->$key);
                }
            }
        }
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
            return false;
        }

        // Post Request
        return true;
    }

    public function get($field, $default)
    {
        if (isset($this->expands[$field])) {
            return $this->$field ?? null;
        }

        // This is an expandable option therefore it needs to be a
        $value = $this->object->$field->value ?? $default;

        // Format to Carbon Date
        if (in_array($field, $this->dates) && $value) {
            // two types of date format
            // Y-m-d\TH:i:s.uP or Y-m-d\TH:i:sP
            $format = 'Y-m-d\TH:i:s.uP';
            if (strlen($value) == 25) {
                $format = 'Y-m-d\TH:i:sP';
            }

            $value = Carbon::createFromFormat($format, $value);
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