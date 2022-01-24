<?php

namespace MyobAdvanced\Request;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCredentialsException;
use MyobAdvanced\Exception\UnauthorizedException;
use MyobAdvanced\MyobAdvanced;

abstract class Request
{
    protected string $method = 'get';
    protected string $className;
    protected int $attempts = 0;
    protected array $customs = [];

    protected MyobAdvanced $myobAdvanced;
    protected Response $response;

    abstract protected function formatResponse();

    public function __construct($className, $myobAdvanced)
    {
        $this->className    = $className;
        $this->myobAdvanced = $myobAdvanced;
    }

    public function getData()
    {
        return [];
    }

    public function getUri()
    {
        $class = new $this->className();

        return $class->getEndpoint() . '/' . $class->getEndpointVersion() . '/' . $class->getEntity();
    }

    public function send()
    {
        if (!$this->myobAdvanced->isLoggedIn()) {
            $this->myobAdvanced->login();
        }

        $request = Http::baseUrl($this->myobAdvanced->getConfiguration()->getHost() . '/entity/')
                       ->withCookies($this->myobAdvanced->getCookieJar()->toArray(), $this->myobAdvanced->getConfiguration()->getHost());

        $this->response = $request->asJson()->{$this->method}($this->getUri(), $this->getData());

        $this->attempts++;

        try {
            $this->throwExceptions();
        } catch (UnauthorizedException $e) {
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

        if ($this->response->clientError()) {
            if ($this->response->status() == 401) {
                throw new UnauthorizedException();
            }
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