<?php

namespace MyobAdvanced;

/**
 * @method bool getBillToAddressOverride()
 * @method self setBillToAddressOverride(bool $value)
 * @method bool getBillToContactOverride()
 * @method self setBillToContactOverride(bool $value)
 */
class BillingSettings extends AbstractObject
{
    public $expands = [
        'BillToAddress' => Address::class,
        'BillToContact' => Contact::class,
    ];
}