<?php

namespace MyobAdvanced;

use Illuminate\Support\Carbon;
use MyobAdvanced\AttributeDefinition\Value;

/**
 * @method string getAttributeID()
 * @method self setAttributeID(string $value)
 * @method string getControlType()
 * @method self setControlType(string $value)
 * @method Carbon getCreatedDateTime()
 * @method self setCreatedDateTime(Carbon $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method string getEntryMask()
 * @method self setEntryMask(string $value)
 * @method bool getInternal()
 * @method self setInternal(bool $value)
 * @method Carbon getLastModifiedDateTime()
 * @method self setLastModifiedDateTime(Carbon $value)
 * @method string getRegExp()
 * @method self setRegExp(string $value)
 *
 * @method Value[] getValues()
 * @method self setValues(Value[] $values)
 */
class AttributeDefinition extends AbstractObject
{
    public $expands = [
        'Values' => [Value::class],
    ];
}