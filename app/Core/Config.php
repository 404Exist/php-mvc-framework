<?php

namespace App\Core;

class Config
{

    public function config($file)
    {
        $path = $this->getPath($file);
        if (file_exists($path)) {
            $config = require $path;
        }

        foreach ($this->getKeys($file) as $key) {
            $config = $config[$key];
        }

        return $config;
    }

    public function env($key, $default)
    {
        return getenv($key) ?: $default;
    }

    protected function getPath($file)
    {
        return __DIR__ . '/../../config/' . explode('.', $file)[0] . '.php';
    }

    protected function getKeys($file)
    {
        return array_slice(explode('.', $file), 1);
    }
}
