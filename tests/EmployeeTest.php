<?php

namespace MyobAdvanced\Tests;

use Illuminate\Support\Facades\Http;
use MyobAdvanced\Employee;

class EmployeeTest extends Base
{
    public function testEmployeeList()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('employees'));

        $employees = $this->myobAdvanced->search(Employee::class, 5)->send();

        $this->assertCount(5, $employees);

        /** @var Employee $employee */
        $employee = $employees->shift();

        $this->assertEquals('f7e155c5-573c-ec11-aae5-022d1e92410e', $employee->getId());
        $this->assertEquals('7', $employee->getEmployeeID());
        $this->assertEquals('-UNSPEC, -', $employee->getEmployeeName());
        $this->assertEquals('Active', $employee->getStatus());
        $this->assertEquals('2021-11-04 10:01:17', $employee->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
    }

    public function testEmployeeGet()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('employee'));

        /** @var Employee $employee */
        $employee = $this->myobAdvanced->get(Employee::class, '579fb525-0f96-e411-b335-e006e6dac1d7')->send();

        $this->assertEquals('f7e155c5-573c-ec11-aae5-022d1e92410e', $employee->getId());
        $this->assertEquals('7', $employee->getEmployeeID());
        $this->assertEquals('-UNSPEC, -', $employee->getEmployeeName());
        $this->assertEquals('Active', $employee->getStatus());
        $this->assertEquals('2021-11-04 10:01:17', $employee->getLastModifiedDateTime()->format('Y-m-d H:i:s'));
    }
}
