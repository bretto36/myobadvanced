<?php

namespace MyobAdvanced\Request;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCredentialsException;
use MyobAdvanced\MyobAdvanced;

abstract class Request
{
    protected string $method;
    protected string $className;
    protected int $attempts = 0;
    protected array $customs = [];

    protected MyobAdvanced $myobAdvanced;
    protected Response $response;

    abstract protected function formatResponse();

    public function __construct($myobAdvanced)
    {
        $this->myobAdvanced = $myobAdvanced;
    }

    public function send()
    {
        $class = new $this->className();

        $request = Http::baseUrl('https://' . $this->myobAdvanced->getConfiguration()->getHost() . '/entity/')
                       ->withCookies($this->myobAdvanced->getCookieJar()->toArray(), $this->myobAdvanced->getConfiguration()->getHost());

        $this->response = $request->asJson()->{$this->method}($class->getEndpoint() . '/' . $class->getEndpointVersion() . '/' . $class->getEntity());

        $this->attempts++;

        try {
            $this->throwExceptions();
        } catch (InvalidCredentialsException $e) {
            try {
                // Only retry once
                if ($this->attempts >= 1) {
                    throw $e;
                }

                $this->myobAdvanced->login();
            } catch (ApiException $e) {
                throw $e;
            }
        }

        return $this->formatResponse();
    }

    protected function throwExceptions()
    {
        if ($this->response->successful()) {
            return;
        }

        // TODO: Handle Client Error

        if ($this->response->serverError()) {
            $object = $this->response->object();

            if (isset($object->exceptionMessage)) {
                switch ($object->exceptionMessage) {
                    case 'Error: Invalid credentials. Please try again.':
                        throw new InvalidCredentialsException($object->exceptionMessage);
                }
            }

            throw new ApiException('An unknown error occurred');
        }

        try {
            $this->response->throw();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getQuery(): array
    {
        $values = [];

        // Selects
        if (!empty($this->customs)) {
            $values['$custom'] = implode(',', $this->customs);
        }

        return $values;
    }
}