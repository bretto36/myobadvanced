<?php

namespace MyobAdvanced;

use GuzzleHttp\Cookie\CookieJarInterface;
use MyobAdvanced\Request\GetRequest;
use MyobAdvanced\Request\LoginRequest;
use MyobAdvanced\Request\SearchRequest;

class MyobAdvanced
{
    public Configuration $configuration;
    public CookieJarInterface $cookieJar;

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

    public function setCookieJar(CookieJarInterface $cookieJar): static
    {
        $this->cookieJar = $cookieJar;

        return $this;
    }

    public function isLoggedIn(): bool
    {
        $cookies = collect($this->getCookieJar()->toArray());

        return ($cookies->has(['ASP.NET_SessionId', '.ASPXAUTH']));
    }

    public function login()
    {
        return (new LoginRequest($this))->send();
    }

    /**
     * @param $className
     * @param null $pageSize
     * @return SearchRequest
     * @throws Exception\ApiException
     */
    public function search($className, $pageSize = null)
    {
        $searchRequest = new SearchRequest($className, $this, $pageSize);

        $searchRequest->send();

        return $searchRequest;
    }

    /**
     * @param $className
     * @return GetRequest
     * @throws Exception\ApiException
     */
    public function get($className)
    {
        $getRequest = new GetRequest($className, $this);

        return $getRequest->send();
    }
}