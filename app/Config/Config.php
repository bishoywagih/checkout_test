<?php

namespace App\Config;

class Config
{
    protected array $config;

    public function load(array $files): self
    {
        foreach ($files as $fileName => $file) {
            $this->config[$fileName] = require_once $file;
        }
        return $this;
    }

    public function get($key, $default = null)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return $default;
    }
}
