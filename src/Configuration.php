<?php

namespace MyobAdvanced;

class Configuration
{
    public string $host;
    public string $username;
    public string $password;
    public string $company;
    public string $branch;

    protected array $options = [];

    public function __construct($host = '', $username = '', $password = '', $company = '', $branch = '')
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->company  = $company;
        $this->branch   = $branch;
    }

    public function setOptions($options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getHost(): string
    {
        if (!str_starts_with($this->host, 'http')) {
            $this->host = 'https://' . $this->host;
        }

        return $this->host;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getBranch(): string
    {
        return $this->branch;
    }

    public function getCookieHost(): string
    {
        return str_starts_with($this->getHost(), 'https://') ? substr($this->getHost(), strlen('https://')) : $this->getHost();
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}