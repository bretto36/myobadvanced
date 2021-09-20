<?php

namespace MyobAdvanced;

use Carbon\Carbon;

/**
 * @method bool hasAccountCD()
 * @method string getAccountCD()
 * @method $this setAccountCD(string $value)
 * @method bool hasAccountClass()
 * @method string getAccountClass()
 * @method $this setAccountClass(string $value)
 * @method bool hasAccountGroup()
 * @method string getAccountGroup()
 * @method $this setAccountGroup(string $value)
 * @method bool hasAccountID()
 * @method int getAccountID()
 * @method $this setAccountID(int $value)
 * @method bool hasActive()
 * @method bool getActive()
 * @method $this setActive(bool $value)
 * @method bool hasCashAccount()
 * @method bool getCashAccount()
 * @method $this setCashAccount(bool $value)
 * @method bool hasChartOfAccountsOrder()
 * @method int getChartOfAccountsOrder()
 * @method $this setChartOfAccountsOrder(int $value)
 * @method bool hasConsolidationAccount()
 * @method string getConsolidationAccount()
 * @method $this setConsolidationAccount(string $value)
 * @method bool hasCreatedDateTime()
 * @method Carbon getCreatedDateTime()
 * @method $this setCreatedDateTime(Carbon $value)
 * @method bool hasCurrencyID()
 * @method string getCurrencyID()
 * @method $this setCurrencyID(string $value)
 * @method bool hasDescription()
 * @method string getDescription()
 * @method $this setDescription(string $value)
 * @method bool hasLastModifiedDateTime()
 * @method Carbon getLastModifiedDateTime()
 * @method $this setLastModifiedDateTime(Carbon $value)
 * @method bool hasPostOption()
 * @method string getPostOption()
 * @method $this setPostOption(string $value)
 * @method bool hasRequireUnits()
 * @method bool getRequireUnits()
 * @method $this setRequireUnits(bool $value)
 * @method bool hasRevaluationRateType()
 * @method string getRevaluationRateType()
 * @method $this setRevaluationRateType(string $value)
 * @method bool hasSecured()
 * @method bool getSecured()
 * @method $this setSecured(bool $value)
 * @method bool hasTaxCategory()
 * @method string getTaxCategory()
 * @method $this setTaxCategory(string $value)
 * @method bool hasType()
 * @method string getType()
 * @method $this setType(string $value)
 * @method bool hasUseDefaultSubaccount()
 * @method bool getUseDefaultSubaccount()
 * @method $this setUseDefaultSubaccount(bool $value)
 */
class Account extends AbstractObject
{
    // TODO: Convert to carbons
    public string $entity = 'Account';

    protected array $dates = [
        'CreatedDateTime',
        'LastModifiedDateTime',
    ];
}