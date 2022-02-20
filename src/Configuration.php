<?php

namespace MyobAdvanced;

class Configuration
{
    public $host;
    public $username;
    public $password;
    public $company;
    public $branch;

    public function __construct($host = '', $username = '', $password = '', $company = '', $branch = '')
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->company  = $company;
        $this->branch   = $branch;
    }

    public function getHost()
    {
        if (substr($this->host, 0, 4) != 'http') {
            $this->host = 'https://' . $this->host;
        }

        return $this->host;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getBranch()
    {
        return $this->branch;
    }

    public function getCookieHost()
    {
        return strpos($this->getHost(), 'https://') === 0 ? substr($this->getHost(), strlen('https://')) : $this->getHost();
    }
}