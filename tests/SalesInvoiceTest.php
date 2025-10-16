<?php

namespace MyobAdvanced\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MyobAdvanced\SalesInvoice;

class SalesInvoiceTest extends Base
{
    public function testSalesInvoiceList()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('sales_invoices'));

        $salesInvoices = $this->myobAdvanced
            ->search(SalesInvoice::class, 5)
            ->addExpand(['BillingSettings', 'Details', 'DiscountDetails', 'FinancialDetails', 'FreightDetails'])
            ->addFilter('CustomerID', 'CUST001')
            ->addFilter('Date', 'gte', '2021-02-12')
            ->send();

        Http::assertSent(function (Request $request) {
            return $request->toPsrRequest()->getUri()->getPath() == '/entity/Default/20.200.001/SalesInvoice' && Str::containsAll(urldecode($request->toPsrRequest()->getUri()->getQuery()), [
                    'CustomerID eq \'CUST001\'',
                    'BillingSettings',
                    'Details',
                    'DiscountDetails',
                    'FinancialDetails',
                    'FreightDetails',
                ]);
        });

        $this->assertCount(5, $salesInvoices);

        /** @var SalesInvoice $salesInvoice */
        $salesInvoice = $salesInvoices->shift();

        $this->assertEquals('ae54df65-378e-e511-80ee-029eaf28db22', $salesInvoice->getId());
        $this->assertEquals('000001', $salesInvoice->getReferenceNbr());
        $this->assertEquals('ELITEANSW', $salesInvoice->getCustomerID());
        $this->assertEquals('2013-07-07 00:00:00', $salesInvoice->getDate()->format('Y-m-d H:i:s'));
        $this->assertEquals('2013-08-30 00:00:00', $salesInvoice->getDueDate()->format('Y-m-d H:i:s'));
        $this->assertEquals('Invoice', $salesInvoice->getType());

        $this->assertCount(4, $salesInvoice->getDetails());

        $detail = $salesInvoice->getDetails()->shift();

        $this->assertEquals(3522.75, $detail->getAmount());
        $this->assertEquals('Income - Sales', $detail->getDescription());
        $this->assertEquals(0, $detail->getDiscountAmount());
        $this->assertEquals(0, $detail->getDiscountPercent());
        $this->assertEquals('X053XUS120', $detail->getInventoryID());
        $this->assertEquals(1, $detail->getLineNbr());
        $this->assertEquals(5, $detail->getQty());
        $this->assertTrue($detail->getManualDiscount());
        $this->assertEquals('MLB', $detail->getWarehouseID());
    }

    public function testSalesInvoiceGet()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('sales_invoice'));

        /** @var SalesInvoice $salesInvoice */
        $salesInvoice = $this->myobAdvanced
            ->get(SalesInvoice::class, 'ae54df65-378e-e511-80ee-029eaf28db22')
            ->addExpand(['ApplicationsCreditMemo', 'ApplicationsInvoice', 'BillingSettings', 'Commissions', 'Details', 'DiscountDetails', 'FinancialDetails', 'FreightDetails'])
            ->send();

        Http::assertSent(function (Request $request) {
            return $request->toPsrRequest()->getUri()->getPath() == '/entity/Default/20.200.001/SalesInvoice/ae54df65-378e-e511-80ee-029eaf28db22' && Str::containsAll(urldecode($request->toPsrRequest()->getUri()->getQuery()), [
                    'ApplicationsCreditMemo',
                    'ApplicationsInvoice',
                    'BillingSettings',
                    'Commissions',
                    'Details',
                    'DiscountDetails',
                    'FinancialDetails',
                    'FreightDetails',
                ]);
        });

        $this->assertEquals('ae54df65-378e-e511-80ee-029eaf28db22', $salesInvoice->getId());
        $this->assertEquals('000001', $salesInvoice->getReferenceNbr());
        $this->assertEquals('ELITEANSW', $salesInvoice->getCustomerID());
        $this->assertEquals('2013-07-07 00:00:00', $salesInvoice->getDate()->format('Y-m-d H:i:s'));
        $this->assertEquals('2013-08-30 00:00:00', $salesInvoice->getDueDate()->format('Y-m-d H:i:s'));
        $this->assertEquals('Invoice', $salesInvoice->getType());

        $this->assertCount(4, $salesInvoice->getDetails());

        $detail = $salesInvoice->getDetails()->shift();

        $this->assertEquals(3522.75, $detail->getAmount());
        $this->assertEquals('Income - Sales', $detail->getDescription());
        $this->assertEquals(0, $detail->getDiscountAmount());
        $this->assertEquals(0, $detail->getDiscountPercent());
        $this->assertEquals('X053XUS120', $detail->getInventoryID());
        $this->assertEquals(1, $detail->getLineNbr());
        $this->assertEquals(5, $detail->getQty());
        $this->assertTrue($detail->getManualDiscount());
        $this->assertEquals('MLB', $detail->getWarehouseID());
    }
}
