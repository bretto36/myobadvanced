<?php

namespace MyobAdvanced\Tests;

use GuzzleHttp\Cookie\SetCookie;
use MyobAdvanced\Configuration;
use MyobAdvanced\MyobAdvanced;
use MyobAdvanced\Tests\Helpers\TempCookieJar;
use Orchestra\Testbench\TestCase as Orchestra;

class Base extends Orchestra
{
    protected MyobAdvanced $myobAdvanced;
    protected Configuration $configuration;
    protected string $host = 'testing.myobadvanced.com';

    public function setUp(): void
    {
        parent::setUp();

        $cookieJar = new TempCookieJar();

        // Make it logged in by default
        $cookieJar->setCookie(new SetCookie([
            'Domain'  => $this->host,
            'Name'    => '.ASPXAUTH',
            'Value'   => '3C0CFC1E18FE09ADB6FF4C65935A25BDA7F8ED470B1917B0C3045219B2C96670A1AADADFB1790D0AD3FCA5CABF22938CDD0E54BC7DC732233565E57C45A43228345C000A754787D63DC846C5A8C70B3BD6FE535FCB1EF4B1CFB93E2B7C10BE6170BF4A521A91C6203E17FB6B588905AB485D4EB23AF487582340B45855DA1D9B4B80717FFF7FD7DACC12E1B68568C23681AD5F41; path=/; HttpOnly',
            'Discard' => true,
        ]));

        $cookieJar->setCookie(new SetCookie([
            'Domain'  => $this->host,
            'Name'    => 'ASP.NET_SessionId',
            'Value'   => '4no3iumzz3lp1ld3ts0z5rz3; path=/; HttpOnly',
            'Discard' => true,
        ]));

        $this->configuration = new Configuration($this->host, 'API', 'PASSWORD', 'Company', 'MAIN');
        $this->myobAdvanced  = new MyobAdvanced($this->configuration, $cookieJar);
    }

    protected function loadJsonResponse($file)
    {
        return \Illuminate\Support\Facades\File::get(dirname(__FILE__) . '/json/' . $file . '.json');
    }
}
