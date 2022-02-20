<?php

namespace MyobAdvanced;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use MyobAdvanced\Request\GetRequest;
use MyobAdvanced\Request\LoginRequest;
use MyobAdvanced\Request\SearchRequest;

class MyobAdvanced
{
    /** @var Configuration Configuration */
    public $configuration;
    /** @var CookieJarInterface|CookieJar */
    public $cookieJar;

    public function __construct($host, $username, $password = '', $company = '', $branch = '', $cookieJar = null)
    {
        if (is_a($host, Configuration::class)) {
            $this->configuration = $host;
            $this->cookieJar     = $username;
        } else {
            $this->configuration = new Configuration($host, $username, $password, $company, $branch);
            $this->cookieJar     = $cookieJar;
        }
    }

    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    public function getCookieJar()
    {
        return $this->cookieJar;
    }

    /**
     * @param CookieJarInterface|CookieJar $cookieJar
     * @return $this
     */
    public function setCookieJar($cookieJar)
    {
        $this->cookieJar = $cookieJar;

        return $this;
    }

    public function isLoggedIn(): bool
    {
        $cookies = collect($this->getCookieJar()->toArray());

        return $cookies->contains('Name', 'ASP.NET_SessionId') && $cookies->contains('Name', '.ASPXAUTH');
    }

    /**
     * @return PromiseInterface|Response
     * @throws Exception\ApiException
     * @throws Exception\InvalidCredentialsException
     */
    public function login()
    {
        return (new LoginRequest('', $this))->send();
    }

    /**
     * @param $className
     * @param null $pageSize
     * @return SearchRequest
     */
    public function search($className, $pageSize = null)
    {
        return new SearchRequest($className, $this, $pageSize);
    }

    /**
     * @param $className
     * @param $id
     * @return GetRequest
     */
    public function get($className, $id)
    {
        return new GetRequest($className, $this, $id);
    }

    public function getCookiesFromCookieJar()
    {
        $cookies = [];
        /** @var SetCookie $cookie */
        foreach ($this->cookieJar as $cookie) {
            $cookies[$cookie->getName()] = $cookie->getValue();
        }

        return $cookies;
    }
}