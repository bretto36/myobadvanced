<?php

namespace MyobAdvanced\Tests;

use MyobAdvanced\Customer;

class GetRequestTest extends Base
{
    public function test_get_request()
    {
        $getRequest = $this->myobAdvanced->get(Customer::class, 'CUSTDFT')
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
        ], $getRequest->getSelects());

        $this->assertEquals(['Attributes', 'BillingContact'], $getRequest->getExpands());
    }
}
