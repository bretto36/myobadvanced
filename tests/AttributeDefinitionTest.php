<?php

namespace MyobAdvanced\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\AttributeDefinition;

class AttributeDefinitionTest extends Base
{
    public function test_retrieve_data()
    {
        Http::fakeSequence()->push($this->loadJsonResponse('attribute_definitions'));

        $attributeDefinitions = $this->myobAdvanced
            ->search(AttributeDefinition::class, 10)
            ->addExpand('Values')
            ->send();

        Http::assertSent(function (Request $request) {
            // Can't use the Request to check GET Params as the object doesn't understand the data
            // Also can't get it to send an empty object tag
            return $request->toPsrRequest()->getUri()->getPath() == '/entity/Default/20.200.001/AttributeDefinition'
                && $request->toPsrRequest()->getUri()->getQuery() == '%24expand=Values'
                && $request->body() == '{"blankObject":true}';
        });

        $this->assertCount(2, $attributeDefinitions);

        /** @var AttributeDefinition $attributeDefinition */
        $attributeDefinition = $attributeDefinitions->shift();

        $this->assertEquals('81d2a148-9163-e411-9b56-001e4f4a3584', $attributeDefinition->getId());
        $this->assertEquals('ASTRA', $attributeDefinition->getCompanyID());
        $this->assertEquals('Astra Partners', $attributeDefinition->getCompanyName());
        $this->assertEquals(true, $attributeDefinition->getCompanyStatus());
        $this->assertEquals('ASTRA', $attributeDefinition->getBranchID());
        $this->assertEquals('Astra Partners', $attributeDefinition->getBranchName());
    }
}
