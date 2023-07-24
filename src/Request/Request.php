<?php

namespace MyobAdvanced\Request;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCompanyException;
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

    public function getUri()
    {
        return $this->class->getEndpoint() . '/' . $this->class->getEndpointVersion() . '/' . $this->class->getEntity();
    }

    /**
     * @return mixed
     * @throws ApiException
     * @throws InvalidCredentialsException
     * @throws UnauthorizedException|RequestException
     */
    public function send()
    {
        if (!$this->myobAdvanced->isLoggedIn()) {
            $this->myobAdvanced->login();
        }

        $request = Http::baseUrl($this->myobAdvanced->getConfiguration()->getHost() . '/entity/')
            ->timeout($this->myobAdvanced->getConfiguration()->getOptions()['timeout'] ?? 10)
            ->withCookies($this->myobAdvanced->getCookiesFromCookieJar(), $this->myobAdvanced->getConfiguration()->getCookieHost());

        // Add any middleware if applicable
        if (!empty($this->myobAdvanced->getMiddleware())) {
            foreach ($this->myobAdvanced->getMiddleware() as $middleware) {
                $request->withMiddleware($middleware);
            }
        }

        if ($this->method == 'get') {
            $this->response = $request->asJson()->get($this->getUri(), $this->getQuery());
        } else {
            $this->response = $request->asJson()
                ->withOptions([
                    'query' => $this->getQuery(),
                ])->{$this->method}($this->getUri(), $this->getBody());
        }

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

        if ($this->response->serverError()) {
            $object = $this->response->object();

            if (isset($object->exceptionMessage)) {
                switch ($object->exceptionMessage) {
                    case 'Error: Invalid credentials. Please try again.':
                        throw new InvalidCredentialsException($object->exceptionMessage);
                    case 'A proper company ID cannot be determined for the request.':
                        throw new InvalidCompanyException($object->exceptionMessage);
                }

                throw new ApiException($object->exceptionMessage);
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

        // Customs
        if (!empty($this->customs)) {
            $values['$custom'] = implode(',', $this->customs);
        }

        return $values;
    }

    public function getBody()
    {
        return null;
    }
}