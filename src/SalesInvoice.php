<?php

namespace MyobAdvanced;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use MyobAdvanced\SalesInvoice\ApplicationInvoice;
use MyobAdvanced\SalesInvoice\ApplicationsCreditMemo;
use MyobAdvanced\SalesInvoice\Commissions;
use MyobAdvanced\SalesInvoice\Detail;
use MyobAdvanced\SalesInvoice\DiscountDetail;
use MyobAdvanced\SalesInvoice\FinancialDetail;
use MyobAdvanced\SalesInvoice\FreightDetail;
use MyobAdvanced\SalesInvoice\TaxDetail;

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
 *
 * @method ApplicationsCreditMemo[]|Collection getApplicationsCreditMemo()
 * @method ApplicationInvoice[]|Collection getApplicationsInvoice()
 * @method BillingSettings getBillingSettings()
 * @method Commissions[]|Collection getCommissions()
 * @method Detail[]|Collection getDetails()
 * @method DiscountDetail[]|Collection getDiscountDetails()
 * @method FinancialDetail getFinancialDetails()
 * @method FreightDetail[]|Collection getFreightDetails()
 * @method TaxDetail[]|Collection getTaxDetails()
 */
class SalesInvoice extends AbstractObject
{
    public array $expands = [
        'ApplicationsCreditMemo' => [ApplicationsCreditMemo::class],
        'ApplicationsInvoice'    => [ApplicationInvoice::class],
        'BillingSettings'        => BillingSettings::class,
        'Commissions'            => [Commissions::class],
        'Details'                => [Detail::class],
        'DiscountDetails'        => [DiscountDetail::class],
        'FinancialDetails'       => FinancialDetail::class,
        'FreightDetails'         => [FreightDetail::class],
        'TaxDetails'             => [TaxDetail::class],
    ];

    protected array $dates = [
        'Date',
        'DueDate',
    ];
}