<?php

namespace MyobAdvanced\Project;

use Carbon\Carbon;
use MyobAdvanced\AbstractObject;

/**
 * @method string getAllocationRule()
 * @method self setAllocationRule(string $value)
 * @method bool getAutomaticallyReleaseARDocuments()
 * @method self setAutomaticallyReleaseARDocuments(bool $value)
 * @method string getBillingPeriod()
 * @method self setBillingPeriod(string $value)
 * @method string getBillingRule()
 * @method self setBillingRule(string $value)
 * @method string getBranch()
 * @method self setBranch(string $value)
 * @method bool getCreateProFormaOnBilling()
 * @method self setCreateProFormaOnBilling(bool $value)
 * @method Carbon getLastBillingDate()
 * @method self setLastBillingDate(Carbon $value)
 * @method Carbon getNextBillingDate()
 * @method self setNextBillingDate(Carbon $value)
 * @method string getRateTable()
 * @method self setRateTable(string $value)
 * @method float getRetainage()
 * @method self setRetainage(float $value)
 * @method bool getRunAllocationOnReleaseOfProjectTransactions()
 * @method self setRunAllocationOnReleaseOfProjectTransactions(bool $value)
 * @method string getTerms()
 * @method self setTerms(string $value)
 * @method bool getUseTMRevenueBudgetLimits()
 * @method self setUseTMRevenueBudgetLimits(bool $value)
 */
class BillingAndAllocationSettings extends AbstractObject
{
    protected $dates = [
        'LastBillingDate',
        'NextBillingDate',
    ];
}