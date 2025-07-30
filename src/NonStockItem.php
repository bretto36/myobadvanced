<?php

namespace MyobAdvanced;

use Carbon\Carbon;

/**
 * @method string getBaseUnit()
 * @method self setBaseUnit(string $value)
 * @method float getCurrentCost()
 * @method self setCurrentCost(float $value)
 * @method float getDefaultPrice()
 * @method self setDefaultPrice(float $value)
 * @method string getDeferralAccount()
 * @method self setDeferralAccount(string $value)
 * @method string getDeferralSubaccount()
 * @method self setDeferralSubaccount(string $value)
 * @method string getDescription()
 * @method self setDescription(string $value)
 * @method Carbon getEffectiveDate()
 * @method self setEffectiveDate(Carbon $value)
 * @method string getExpenseAccount()
 * @method self setExpenseAccount(string $value)
 * @method string getExpenseAccrualAccount()
 * @method self setExpenseAccrualAccount(string $value)
 * @method string getExpenseAccrualSubaccount()
 * @method self setExpenseAccrualSubaccount(string $value)
 * @method string getExpenseSubaccount()
 * @method self setExpenseSubaccount(string $value)
 * @method string getInventoryID()
 * @method self setInventoryID(string $value)
 * @method bool getIsKit()
 * @method self setIsKit(bool $value)
 * @method string getItemClass()
 * @method self setItemClass(string $value)
 * @method string getItemStatus()
 * @method self setItemStatus(string $value)
 * @method string getItemType()
 * @method self setItemType(string $value)
 * @method float getLastCost()
 * @method self setLastCost(float $value)
 * @method Carbon getLastModifiedDateTime()
 * @method self setLastModifiedDateTime(Carbon $value)
 * @method float getPendingCost()
 * @method self setPendingCost(float $value)
 * @method Carbon getPendingCostDate()
 * @method self setPendingCostDate(Carbon $value)
 * @method string getPOAccrualAccount()
 * @method self setPOAccrualAccount(string $value)
 * @method string getPOAccrualSubaccount()
 * @method self setPOAccrualSubaccount(string $value)
 * @method string getPostingClass()
 * @method self setPostingClass(string $value)
 * @method string getPriceClass()
 * @method self setPriceClass(string $value)
 * @method string getPurchasePriceVarianceAccount()
 * @method self setPurchasePriceVarianceAccount(string $value)
 * @method string getPurchasePriceVarianceSubaccount()
 * @method self setPurchasePriceVarianceSubaccount(string $value)
 * @method string getPurchaseUnit()
 * @method self setPurchaseUnit(string $value)
 * @method string getReasonCodeSubaccount()
 * @method self setReasonCodeSubaccount(string $value)
 * @method bool getRequireReceipt()
 * @method self setRequireReceipt(bool $value)
 * @method bool getRequireShipment()
 * @method self setRequireShipment(bool $value)
 * @method string getSalesAccount()
 * @method self setSalesAccount(string $value)
 * @method string getSalesSubaccount()
 * @method self setSalesSubaccount(string $value)
 * @method string getSalesUnit()
 * @method self setSalesUnit(string $value)
 * @method string getTaxCategory()
 * @method self setTaxCategory(string $value)
 * @method float getVolume()
 * @method self setVolume(float $value)
 * @method string getVolumeUOM()
 * @method self setVolumeUOM(string $value)
 * @method float getWeight()
 * @method self setWeight(float $value)
 * @method string getWeightUOM()
 * @method self setWeightUOM(string $value)
 */
class NonStockItem extends AbstractObject
{
    public array $expands = [
        'Attributes' => [Attribute::class],
        //'CrossReferences' => [CrossReference::class],
        //'SalesCategories' => [SalesCategory::class],
        //'VendorDetails' => [VendorDetail::class],
    ];

    protected array $dates = [
        'CreatedDateTime',
        'EffectiveDate',
        'LastModifiedDateTime',
        'PendingCostDate',
    ];
}