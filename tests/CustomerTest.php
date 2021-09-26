<?php

namespace MyobAdvanced\Tests;

use Illuminate\Support\Facades\Http;
use MyobAdvanced\Customer;

class CustomerTest extends Base
{
    public function testCustomerList()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('customers'));

        $customers = $this->myobAdvanced->search(Customer::class, 5)->send();

        $this->assertCount(5, $customers);

        /** @var Customer $customer */
        $customer = $customers->shift();

        $this->assertEquals('579fb525-0f96-e411-b335-e006e6dac1d7', $customer->getId());
        $this->assertEquals('ABARTENDE', $customer->getCustomerID());
        $this->assertEquals('Active', $customer->getStatus());
        $this->assertEquals('2021-02-08 15:46:23', $customer->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('DEFAULT', $customer->getCustomerClass());
    }

    public function testCustomerGet()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('customer'));

        /** @var Customer $customer */
        $customer = $this->myobAdvanced->get(Customer::class, '579fb525-0f96-e411-b335-e006e6dac1d7')->send();

        $this->assertEquals('579fb525-0f96-e411-b335-e006e6dac1d7', $customer->getId());
        $this->assertEquals('ABARTENDE', $customer->getCustomerID());
        $this->assertEquals('Active', $customer->getStatus());
        $this->assertEquals('2021-02-08 15:46:23', $customer->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('DEFAULT', $customer->getCustomerClass());
    }
}
