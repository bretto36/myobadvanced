<?php

namespace MyobAdvanced\Tests;

use Illuminate\Support\Facades\Http;
use MyobAdvanced\CustomerClass;

class CustomerClassTest extends Base
{
    public function testCustomerClassList()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('customer_classes'));

        $customerClasses = $this->myobAdvanced->search(CustomerClass::class, 10)->send();

        $this->assertCount(1, $customerClasses);

        /** @var CustomerClass $customerClass */
        $customerClass = $customerClasses->shift();

        $this->assertEquals('CUSTDFT', $customerClass->getClassID());
        $this->assertEquals('Customer Default', $customerClass->getDescription());
        $this->assertEquals('2022-08-04 14:58:48', $customerClass->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
    }

    public function testCustomerClassGet()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('customer_class'));

        /** @var CustomerClass $customerClass */
        $customerClass = $this->myobAdvanced->get(CustomerClass::class, 'CUSTDFT')->send();

        $this->assertEquals('CUSTDFT', $customerClass->getClassID());
        $this->assertEquals('Customer Default', $customerClass->getDescription());
        $this->assertEquals('2022-08-04 14:58:48', $customerClass->getLastModifiedDateTime()->format('Y-m-d H:i:s'));

        $this->assertCount(2, $customerClass->getAttributes());

        $attribute = $customerClass->getAttributes()->shift();

        $this->assertEquals('CUSTDFT', $attribute->getClassID());
        dump($attribute);
    }
}
