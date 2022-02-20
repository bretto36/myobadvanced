<?php

namespace MyobAdvanced;

use Carbon\Carbon;
use MyobAdvanced\SalesInvoice\Detail;

/**
 * @method float getAmount()
 * @method self setAmount(float $value)
 * @method float getBalance()
 * @method self setBalance(float $value)
 * @method bool getBillingPrinted()
 * @method self setBillingPrinted(bool $value)
 * @method bool getBillToContactOverride()
 * @method self setBillToContactOverride(bool $value)
 * @method Carbon getCreatedDateTime()
 * @method self setCreatedDateTime(Carbon $value)
 * @method string getCustomer()
 * @method self setCustomer(string $value)
 * @method string getCustomerOrder()
 * @method self setCustomerOrder(string $value)
 * @method Carbon getDate()
 * @method self setDate(Carbon $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method Carbon getDueDate()
 * @method self setDueDate(Carbon $value)
 * @method bool getHold()
 * @method self setHold(bool $value)
 * @method Carbon getLastModifiedDateTime()
 * @method self setLastModifiedDateTime(Carbon $value)
 * @method string getLinkARAccount()
 * @method self setLinkARAccount(string $value)
 * @method string getLinkBranch()
 * @method self setLinkBranch(string $value)
 * @method string getLocationID()
 * @method self setLocationID(string $value)
 * @method string getPostPeriod()
 * @method self setPostPeriod(string $value)
 * @method string getProject()
 * @method self setProject(string $value)
 * @method string getReferenceNbr()
 * @method self setReferenceNbr(string $value)
 * @method string getStatus()
 * @method self setStatus(string $value)
 * @method bool getShipToContactOverride()
 * @method self setShipToContactOverride(bool $value)
 * @method float getTaxTotal()
 * @method self setTaxTotal(float $value)
 * @method string getTerms()
 * @method self setTerms(string $value)
 * @method string getType()
 * @method self setType(string $value)
 * @method Contact getBillToContact()
 * @method self setBillToContact(Contact $value)
 */
class Invoice extends AbstractObject
{
    public $expands = [
        //'ApplicationsCreditMemo' => ApplicationsCreditMemo::class, // Array
        //'ApplicationsDefault'    => ApplicationsDefault::class, // Array
        'BillToContact' => Contact::class,
        'Details'       => [Detail::class],
    ];

    protected $dates = [
        'CreatedDateTime',
        'LastModifiedDateTime',
        'Date',
        'DueDate',
    ];
}