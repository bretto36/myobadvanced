<?php

namespace MyobAdvanced\Request;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCredentialsException;

class LoginRequest extends Request
{
    /**
     * @return PromiseInterface|Response
     * @throws InvalidCredentialsException
     * @throws ApiException|RequestException
     */
    public function send(): PromiseInterface|Response
    {
        $this->response = Http::asJson()->post($this->myobAdvanced->getConfiguration()->getHost() . '/entity/auth/login', [
            'name'     => $this->myobAdvanced->getConfiguration()->getUsername(),
            'password' => $this->myobAdvanced->getConfiguration()->getPassword(),
            'company'  => $this->myobAdvanced->getConfiguration()->getCompany(),
            'branch'   => $this->myobAdvanced->getConfiguration()->getBranch(),
        ]);

        $this->throwExceptions();

        // handle response
        foreach ($this->response->cookies() as $value) {
            $this->myobAdvanced->getCookieJar()->setCookie($value);
        }

        // Check if successful

        return $this->response;
    }

    public function formatResponse(): string
    {
        return '';
    }
}