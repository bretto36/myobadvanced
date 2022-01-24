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

    public function setCookieJar(CookieJarInterface $cookieJar)
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
     * @return GetRequest
     */
    public function get($className, $id)
    {
        return new GetRequest($className, $this, $id);
    }
}