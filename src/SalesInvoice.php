<?php

namespace MyobAdvanced;

use Carbon\Carbon;

/**
 * @method float getAmount()
 * @method self setAmount(float $value)
 * @method float getBalance()
 * @method self setBalance(float $value)
 * @method float getCashDiscount()
 * @method self setCashDiscount(float $value)
 * @method bool getCreditHold()
 * @method self setCreditHold(bool $value)
 * @method string getCustomerID()
 * @method self setCustomerID(string $value)
 * @method string getCustomerOrder()
 * @method self setCustomerOrder(string $value)
 * @method Carbon getDate()
 * @method self setDate(Carbon $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method float getDetailTotal()
 * @method self setDetailTotal(float $value)
 * @method float getDiscountTotal()
 * @method self setDiscountTotal(float $value)
 * @method Carbon getDueDate()
 * @method self setDueDate(Carbon $value)
 * @method float getFreightPrice()
 * @method self setFreightPrice(float $value)
 * @method bool getHold()
 * @method self setHold(bool $value)
 * @method float getPaymentTotal()
 * @method self setPaymentTotal(float $value)
 * @method string getProject()
 * @method self setProject(string $value)
 * @method string getReferenceNbr()
 * @method self setReferenceNbr(string $value)
 * @method string getStatus()
 * @method self setStatus(string $value)
 * @method float getTaxTotal()
 * @method self setTaxTotal(float $value)
 * @method string getType()
 * @method self setType(string $value)
 * @method float getVATExemptTotal()
 * @method self setVATExemptTotal(float $value)
 * @method float getVATTaxableTotal()
 * @method self setVATTaxableTotal(float $value)
 */
class SalesInvoice extends AbstractObject
{
    public array $expands = [
        //'ApplicationsCreditMemo' => ApplicationsCreditMemo::class, // Array
        //'ApplicationsDefault'    => ApplicationsDefault::class, // Array
        'BillingSettings' => BillingSettings::class,
        'Details'         => SalesInvoiceDetail::class, // Array
        'DiscountDetails' => SalesInvoiceDiscountDetail::class, // Array
        'FinancialDetails' => SalesInvoiceDiscountDetail::class, // Array
    ];

    // TODO: Finish

}