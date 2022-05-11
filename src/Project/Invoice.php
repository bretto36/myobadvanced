<?php

namespace MyobAdvanced\Project;

use Carbon\Carbon;
use MyobAdvanced\AbstractObject;

/**
 * @method Carbon getARDocDate()
 * @method self setARDocDate(Carbon $value)
 * @method string getARDocDescription()
 * @method self setARDocDescription(string $value)
 * @method float getARDocOriginalAmount()
 * @method self setARDocOriginalAmount(float $value)
 * @method string getARDocStatus()
 * @method self setARDocStatus(string $value)
 * @method string getARDocType()
 * @method self setARDocType(string $value)
 * @method string getARReferenceNbr()
 * @method self setARReferenceNbr(string $value)
 * @method int getBillingNbr()
 * @method self setBillingNbr(int $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method float getInvoiceTotal()
 * @method self setInvoiceTotal(float $value)
 * @method float getOpenARBalance()
 * @method self setOpenARBalance(float $value)
 * @method string getOriginalRefNbr()
 * @method self setOriginalRefNbr(string $value)
 * @method float getOriginalRetainage()
 * @method self setOriginalRetainage(float $value)
 * @method float getPaidRetainage()
 * @method self setPaidRetainage(float $value)
 * @method Carbon getProFormaDate()
 * @method self setProFormaDate(Carbon $value)
 * @method string getProFormaReferenceNbr()
 * @method self setProFormaReferenceNbr(string $value)
 * @method bool getRetainageInvoice()
 * @method self setRetainageInvoice(bool $value)
 * @method string getStatus()
 * @method self setStatus(string $value)
 * @method float getTotalAmount()
 * @method self setTotalAmount(float $value)
 * @method float getUnpaidRetainage()
 * @method self setUnpaidRetainage(float $value)
 * @method float getUnreleasedRetainage()
 * @method self setUnreleasedRetainage(float $value)
 */
class Invoice extends AbstractObject
{
    protected $dates = [
        'ARDocDate',
        'ProFormaDate',
    ];
}