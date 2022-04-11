<?php

namespace MyobAdvanced\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\CompaniesStructure;

class CompaniesStructureTest extends Base
{
    public function test_retrieve_data()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('companies_structure'));

        $companiesStructures = $this->myobAdvanced->inquiry(CompaniesStructure::class)->send();

        Http::assertSent(function (Request $request) {
            // Can't use the Request to check GET Params as the object doesn't understand the data
            return $request->toPsrRequest()->getUri()->getPath() == '/entity/Default/20.200.001/CompaniesStructure'
                && $request->toPsrRequest()->getUri()->getQuery() == '%24expand=Results';
        });

        $this->assertCount(2, $companiesStructures);

        /** @var CompaniesStructure $companyStructure */
        $companyStructure = $companiesStructures->shift();

        $this->assertEquals('81d2a148-9163-e411-9b56-001e4f4a3584', $companyStructure->getId());
        $this->assertEquals('ASTRA', $companyStructure->getCompanyID());
        $this->assertEquals('Astra Partners', $companyStructure->getCompanyName());
        $this->assertEquals(true, $companyStructure->getCompanyStatus());
        $this->assertEquals('ASTRA', $companyStructure->getBranchID());
        $this->assertEquals('Astra Partners', $companyStructure->getBranchName());
    }
}
