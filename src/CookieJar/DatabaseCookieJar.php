<?php

namespace MyobAdvanced\CookieJar;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Utils;
use RuntimeException;

class DatabaseCookieJar extends CookieJar
{
    /**
     * Create a new FileCookieJar object
     *
     * @throws RuntimeException if the file cannot be found or created
     */
    public function __construct(protected string $filename, protected bool $storeSessionCookies = false)
    {
        parent::__construct();

        if (file_exists($filename)) {
            $this->load($filename);
        }
    }

    /**
     * Saves the file when shutting down
     */
    public function __destruct()
    {
        $this->save($this->filename);
    }

    /**
     * Saves the cookies to a file.
     *
     * @throws RuntimeException if the file cannot be found or created
     */
    public function save(string $filename): void
    {
        $json = [];
        foreach ($this as $cookie) {
            /** @var SetCookie $cookie */
            if (CookieJar::shouldPersist($cookie, $this->storeSessionCookies)) {
                $json[] = $cookie->toArray();
            }
        }

        $jsonStr = Utils::jsonEncode($json);
        if (false === file_put_contents($filename, $jsonStr, LOCK_EX)) {
            throw new RuntimeException("Unable to save file $filename");
        }
    }

    /**
     * Load cookies from a JSON formatted file.
     *
     * Old cookies are kept unless overwritten by newly loaded ones.
     *
     * @throws RuntimeException if the file cannot be loaded.
     */
    public function load(string $filename): void
    {
        $json = file_get_contents($filename);
        if (false === $json) {
            throw new RuntimeException("Unable to load file $filename");
        } elseif ($json === '') {
            return;
        }

        $data = Utils::jsonDecode($json, true);
        if (is_array($data)) {
            foreach (json_decode($json, true) as $cookie) {
                $this->setCookie(new SetCookie($cookie));
            }
        } elseif (strlen($data)) {
            throw new RuntimeException("Invalid cookie file: $filename");
        }
    }
}