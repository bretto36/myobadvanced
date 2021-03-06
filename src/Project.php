<?php

namespace MyobAdvanced;

use MyobAdvanced\Project\Balance;
use MyobAdvanced\Project\BillingAndAllocationSettings;

/**
 * @method float getAssets()
 * @method self setAssets(float $value)
 * @method string getCustomer()
 * @method self setCustomer(string $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method float getExpenses()
 * @method self setExpenses(float $value)
 * @method string getExternalRefNbr()
 * @method self setExternalRefNbr(string $value)
 * @method bool getHold()
 * @method self setHold(bool $value)
 * @method float getIncome()
 * @method self setIncome(float $value)
 * @method float getLiabilities()
 * @method self setLiabilities(float $value)
 * @method string getProjectID()
 * @method self setProjectID(string $value)
 * @method string getProjectTemplateID()
 * @method self setProjectTemplateID(string $value)
 * @method string getStatus()
 * @method self setStatus(string $value)
 *
 * @method BillingAndAllocationSettings getBillingAndAllocationSettings()
 * @method self setBillingAndAllocationSettings(BillingAndAllocationSettings $value)
 * @method Balance[] getBalances()
 * @method self setBalances(BillingAndAllocationSettings[] $value)
 */
class Project extends AbstractObject
{
    public $expands = [
        'BillingAndAllocationSettings' => BillingAndAllocationSettings::class,
        'Balances'                     => [Balance::class],
        'Invoices'                     => [\MyobAdvanced\Project\Invoice::class],
    ];
}