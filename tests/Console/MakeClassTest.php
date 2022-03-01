<?php

namespace MyobAdvanced\Tests\Console;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Tests\Base;

class MakeClassTest extends Base
{
    public function testClassIsGenerated()
    {
        Http::fakeSequence()
            ->push('', 204, [
                'Set-Cookie' => [
                    '.ASPXAUTH=3C0CFC1E18FE09ADB6FF4C65935A25BDA7F8ED470B1917B0C3045219B2C96670A1AADADFB1790D0AD3FCA5CABF22938CDD0E54BC7DC732233565E57C45A43228345C000A754787D63DC846C5A8C70B3BD6FE535FCB1EF4B1CFB93E2B7C10BE6170BF4A521A91C6203E17FB6B588905AB485D4EB23AF487582340B45855DA1D9B4B80717FFF7FD7DACC12E1B68568C23681AD5F41; path=/; HttpOnly',
                    'UserBranch=1; path=/; secure; HttpOnly',
                ],
            ])
            ->push($this->loadJsonResponse('employee_adhocschema'));

        $this->artisan('myob-advanced:make --force=1')
             ->expectsQuestion('Host', 'https://example.myobadvanced.com')
             ->expectsQuestion('Username', 'user')
             ->expectsQuestion('Password', 'pass')
             ->expectsQuestion('Company', 'company')
             ->expectsQuestion('Endpoint', 'Default')
             ->expectsQuestion('Endpoint Version', '20.200.001')
             ->expectsQuestion('Entity', 'Employee')
             ->expectsOutput('MYOB Advanced Class created successfully.')
             ->assertExitCode(0);

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://example.myobadvanced.com/entity/Default/20.200.001/Employee/$adhocSchema';
        });
    }
}