<?php

namespace MyobAdvanced\Tests;

use MyobAdvanced\CompaniesStructure;

class InquiryRequestTest extends Base
{
    public function test_get_request()
    {
        $inquiryRequest = $this->myobAdvanced->inquiry(CompaniesStructure::class)
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
        ], $inquiryRequest->getSelects());

        $this->assertEquals(['Attributes', 'BillingContact'], $inquiryRequest->getExpands());

        $this->assertEquals([
            '$select' => 'ClassID,Description,LastModifiedDateTime,Attributes/AttributeID,Attributes/Description,ARAccount',
            '$expand' => 'Attributes,BillingContact',
        ], $inquiryRequest->getQuery());
    }
}
