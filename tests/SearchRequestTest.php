<?php

namespace MyobAdvanced\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MyobAdvanced\Customer;

class SearchRequestTest extends Base
{
    public function test_get_request()
    {
        $searchRequest = $this->myobAdvanced->search(Customer::class)
            ->setPage(10)
            ->setPageSize(1000)
            ->setSelects([
                'ClassID',
                'Description',
                'LastModifiedDateTime',
                'Attributes/AttributeID',
                'Attributes/Description',
            ])
            ->addSelect('ARAccount')
            ->setExpands(['Attributes'])
            ->addExpand('BillingContact');

        $this->assertEquals([
            'ClassID',
            'Description',
            'LastModifiedDateTime',
            'Attributes/AttributeID',
            'Attributes/Description',
            'ARAccount',
        ], $searchRequest->getSelects());

        $this->assertEquals(['Attributes', 'BillingContact'], $searchRequest->getExpands());

        $this->assertEquals([
            '$select' => 'ClassID,Description,LastModifiedDateTime,Attributes/AttributeID,Attributes/Description,ARAccount',
            '$expand' => 'Attributes,BillingContact',
            '$top'    => 1000,
            '$skip'   => 9000,
        ], $searchRequest->getQuery());
    }

    public function testDateFilter()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('customers'));

        $request = $this->myobAdvanced->search(Customer::class, 5);

        $request->addFilter('LastModifiedDateTime', 'ge', Carbon::createFromFormat('Y-m-d', '2022-02-02')->startOfDay());

        $request->send();

        Http::assertSent(function (Request $request) {
            return $request['$filter'] == 'LastModifiedDateTime ge datetimeoffset\'2022-02-02T00:00:00\'' &&
                Str::contains($request->url(), '/entity/Default/20.200.001/Customer');
        });
    }

    public function testStringFilter()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('customers'));

        $request = $this->myobAdvanced->search(Customer::class, 5);

        $request->addFilter('CustomerID', 'eq', 'ABARTENDE')
            ->addFilter('Status', 'in', ['Closed', 'Open'])
            ->addFilter('Reference', 'not in', ['123', '234']);

        $request->send();

        Http::assertSent(function (Request $request) {
            return $request['$filter'] == 'CustomerID eq \'ABARTENDE\' and (Status eq \'Closed\' or Status eq \'Open\') and (Reference ne \'123\' and Reference ne \'234\')' &&
                Str::contains($request->url(), '/entity/Default/20.200.001/Customer');
        });
    }
}
