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
                && $request->toPsrRequest()->getUri()->getQuery() == '%24expand=Values&%24top=10&%24skip=0';
        });

        $this->assertCount(2, $attributeDefinitions);

        /** @var AttributeDefinition $attributeDefinition */
        $attributeDefinition = $attributeDefinitions->shift();

        $this->assertEquals('EMPBUDGET', $attributeDefinition->getAttributeID());
        $this->assertEquals('Text', $attributeDefinition->getControlType());
        $this->assertEquals('Employees Budget', $attributeDefinition->getDescription());

        /** @var AttributeDefinition $attributeDefinition */
        $attributeDefinition = $attributeDefinitions->shift();

        $this->assertEquals('ENTITYTYPE', $attributeDefinition->getAttributeID());
        $this->assertEquals('Combo', $attributeDefinition->getControlType());
        $this->assertEquals('Entity Type', $attributeDefinition->getDescription());

        $this->assertCount(4, $attributeDefinition->getValues());

        /** @var AttributeDefinition\Value $value */
        $value = $attributeDefinition->getValues()->shift();

        $this->assertEquals('COMPANY', $value->getValueID());
        $this->assertEquals('Company', $value->getDescription());
    }
}
