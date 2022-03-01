<?php

namespace MyobAdvanced\Request;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCredentialsException;
use MyobAdvanced\Exception\UnauthorizedException;
use MyobAdvanced\MyobAdvanced;

abstract class Request
{
    protected $method = 'get';
    protected $class;
    protected $attempts = 0;
    protected $customs = [];

    /** @var MyobAdvanced */
    protected $myobAdvanced;
    /** @var Response */
    protected $response;

    abstract protected function formatResponse();

    public function __construct($class, $myobAdvanced)
    {
        if (!empty($class) && !is_object($class)) {
            $class = new $class();
        }

        $this->class        = $class;
        $this->myobAdvanced = $myobAdvanced;
    }

    public function getData()
    {
        return [];
    }

    public function getUri()
    {
        return $this->class->getEndpoint() . '/' . $this->class->getEndpointVersion() . '/' . $this->class->getEntity();
    }

    /**
     * @return mixed
     * @throws ApiException
     * @throws InvalidCredentialsException
     * @throws UnauthorizedException
     */
    public function send()
    {
        if (!$this->myobAdvanced->isLoggedIn()) {
            $this->myobAdvanced->login();
        }

        $request = Http::baseUrl($this->myobAdvanced->getConfiguration()->getHost() . '/entity/')
                       ->withCookies($this->myobAdvanced->getCookiesFromCookieJar(), $this->myobAdvanced->getConfiguration()->getCookieHost());

        $this->response = $request->asJson()->{$this->method}($this->getUri(), $this->getData());

        try {
            $this->throwExceptions();
        } catch (UnauthorizedException $e) {
            // Only retry once
            if ($this->attempts >= 1) {
                throw $e;
            }

            $this->attempts++;

            $this->myobAdvanced->login();

            $this->send();
        }

        return $this->formatResponse();
    }

    /**
     * @return void
     * @throws ApiException
     * @throws InvalidCredentialsException
     * @throws UnauthorizedException
     * @throws RequestException
     */
    protected function throwExceptions()
    {
        if ($this->response->successful()) {
            return;
        }

        // TODO: Handle Client Error

        if ($this->response->serverError()) {
            $object = $this->response->object();

            if (isset($object->exceptionMessage)) {
                if ($object->exceptionMessage == 'Error: Invalid credentials. Please try again.') {
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

        $this->response->throw();
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