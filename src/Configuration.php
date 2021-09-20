<?php

namespace MyobAdvanced;

class Configuration
{
    public string $host;
    public string $username;
    public string $password;
    public string $company;
    public string $branch;

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
}