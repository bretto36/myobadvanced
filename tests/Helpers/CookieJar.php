<?php

namespace MyobAdvanced\Tests\Helpers;

use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\SetCookie;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CookieJar implements CookieJarInterface
{
    /** @var SetCookie[] */
    protected array $cookies = [];

    public function setCookie(SetCookie $cookie)
    {
        $this->cookies[$cookie->getName()] = $cookie;
    }

    public function toArray()
    {
        $output = [];

        foreach ($this->cookies as $cookie) {
            $output[$cookie->getName()] = $cookie->getValue();
        }

        return $output;
    }

    public function clear($domain = null, $path = null, $name = null)
    {
        // TODO: Implement clear() method.
    }

    public function clearSessionCookies()
    {
        // TODO: Implement clearSessionCookies() method.
    }

    public function extractCookies(RequestInterface $request, ResponseInterface $response)
    {
        // TODO: Implement extractCookies() method.
    }

    public function withCookieHeader(RequestInterface $request)
    {
        // TODO: Implement withCookieHeader() method.
    }

    public function count()
    {
        return count($this->cookies);
    }

    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }
}