<?php

namespace MyobAdvanced;

use Illuminate\Support\Collection;

/**
 * @method string getApplyOverdueCharges()
 * @method self setApplyOverdueCharges(string $value)
 * @method string getARAccount()
 * @method self setARAccount(string $value)
 * @method string getARSubaccount()
 * @method self setARSubaccount(string $value)
 * @method string getAutoApplyPayments()
 * @method self setAutoApplyPayments(string $value)
 * @method string getCashDiscountAccount()
 * @method self setCashDiscountAccount(string $value)
 * @method string getCashDiscountSubaccount()
 * @method self setCashDiscountSubaccount(string $value)
 * @method string getClassID()
 * @method self setClassID(string $value)
 * @method string getCOGSAccount()
 * @method self setCOGSAccount(string $value)
 * @method string getCOGSSubaccount()
 * @method self setCOGSSubaccount(string $value)
 * @method string getCountry()
 * @method self setCountry(string $value)
 * @method string getCreatedDateTime()
 * @method self setCreatedDateTime(string $value)
 * @method string getCreditDaysPastDue()
 * @method self setCreditDaysPastDue(string $value)
 * @method string getCreditLimit()
 * @method self setCreditLimit(string $value)
 * @method string getCreditVerification()
 * @method self setCreditVerification(string $value)
 * @method string getCurrencyID()
 * @method self setCurrencyID(string $value)
 * @method string getCurrencyRateType()
 * @method self setCurrencyRateType(string $value)
 * @method string getDefaultLocationIDfromBranch()
 * @method self setDefaultLocationIDfromBranch(string $value)
 * @method string getDefaultRestrictionGroup()
 * @method self setDefaultRestrictionGroup(string $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method string getDiscountAccount()
 * @method self setDiscountAccount(string $value)
 * @method string getDiscountSubaccount()
 * @method self setDiscountSubaccount(string $value)
 * @method string getTerms()
 * @method self setTerms(string $value)
 *
 * @method Attribute[]|Collection getAttributes()
 * @method self setAttributes(array $value)
 */
class CustomerClass extends AbstractObject
{
    public array $expands = [
        'Attributes' => [Attribute::class],
    ];
}