<?php

namespace MyobAdvanced;

use Carbon\Carbon;
use stdClass;

/**
 * @method \Illuminate\Support\Carbon getLastModifiedDateTime()
 */
abstract class AbstractObject
{
    public string $endpoint = 'Default';
    public string $endpointVersion = '20.200.001';
    public string $entity;

    // The underlying object from the API
    public stdClass $object;
    // A hash that is stored to determine if the entity has changed when save is called
    public string $hash;
    // If true this means the object already has an ID associated with it and any save will attempt to do a PUT request
    public bool $saved = false;

    public array $expands = [];
    public array $expandedObjects = [];

    protected array $dates = [
        'CreatedDateTime',
        'LastModifiedDateTime',
    ];

    public function __construct($object = null)
    {
        $this->object = new stdClass();

        if ($object) {
            $this->loadObject($object);
        }

        $this->resetHash();
    }

    public function resetHash(): void
    {
        $this->hash = $this->getHash();
    }

    public function getObject(): stdClass
    {
        return $this->object;
    }

    public function loadObject($object): void
    {
        $object = is_object($object) ? $object : json_decode($object, false);

        $this->object = $object;

        $this->resetHash();
        $this->saved = true;

        foreach ($this->expands as $key => $type) {
            if (isset($this->object->$key)) {
                if (is_array($type)) {
                    $this->expandedObjects[$key] = collect();

                    // Only set the value if it's an array
                    if (!is_array($this->object->$key)) {
                        continue;
                    }

                    $type = array_shift($type);

                    foreach ($this->object->$key as $subObject) {
                        $this->expandedObjects[$key]->push(new $type($subObject));
                    }
                } else {
                    $this->expandedObjects[$key] = new $type($this->object->$key);
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

    public function setEndpoint($endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getEndpointVersion(): string
    {
        return $this->endpointVersion;
    }

    public function setEndpointVersion($endpointVersion): static
    {
        $this->endpointVersion = $endpointVersion;

        return $this;
    }

    public function getEntity(): string
    {
        return $this->entity ?? class_basename($this);
    }

    public function setEntity($entity): static
    {
        $this->entity = $entity;

        return $this;
    }

    public function getHash(): string
    {
        return sha1(json_encode($this->object));
    }

    public function isDirty(): bool
    {
        return ($this->getHash() != $this->hash);
    }

    public function isSaved(): bool
    {
        return $this->saved;
    }

    public function save(): bool
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
            return $this->expandedObjects[$field] ?? null;
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

    public function set($field, $value): static
    {
        if (is_a($value, Carbon::class)) {
            $value = $value->format('Y-m-d\TH:i:s');
        }

        $this->object->$field->value = $value;

        return $this;
    }

    public function has($field): bool
    {
        return (isset($this->object->$field->value) && null !== $this->object->$field->value);
    }

    public function is($field): bool
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

        throw new \Exception('Method does not exist: ' . $name . ' for class: ' . self::class);
    }
}