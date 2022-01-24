<?php

namespace MyobAdvanced\Request;

use Illuminate\Support\Facades\Http;
use MyobAdvanced\Exception\ApiException;
use MyobAdvanced\Exception\InvalidCredentialsException;

class LoginRequest extends Request
{
    /**
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws InvalidCredentialsException
     * @throws ApiException
     */
    public function send()
    {
        $host = $this->myobAdvanced->getConfiguration()->getHost();

        if (substr($host, 0, 4) != 'http') {
            $host = 'https://' . $host;
        }

        $this->response = Http::asJson()->post($host . '/entity/auth/login', [
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

    protected function formatResponse()
    {
        return;
    }
}