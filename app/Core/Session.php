<?php

namespace App\Core;

class Session
{
    protected const FLASH_KEY = "session_flash";

    public function flash($key, $value)
    {
        $_SESSION[self::FLASH_KEY][$key] = $value;
        return $this;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function has($key)
    {
        return isset($_SESSION[$key]) || isset($_SESSION[self::FLASH_KEY][$key]);
    }

    public function forget($key)
    {
        unset($_SESSION[$key]);
        return $this;
    }

    public function get($key, $default = false)
    {
        return $this->getNestedValueOrDefault($key, $default);
    }

    public function flush()
    {
        session_unset();
        session_destroy();
        return $this;
    }
    
    public function unsetFlashes()
    {
        unset($_SESSION[self::FLASH_KEY]);
        return $this;
    }

    protected function getNestedValueOrDefault($key, $default = false)
    {
        $value = $this->getValueOrDefault($key, $default);
        $keys = array_slice(explode('.', $key), 1);
        foreach ($keys as $arrKey) {
            if (is_array($value)) $value = $value[$arrKey] ?? $default;
            else $value = $value->$arrKey ?? $default;
        }
        return $value;
    }

    protected function getValueOrDefault($key, $default)
    {
        $key = explode('.', $key)[0];
        if (isset($_SESSION[$key])) return $_SESSION[$key];
        if (isset($_SESSION[self::FLASH_KEY][$key]))  return $_SESSION[self::FLASH_KEY][$key];
        return $default;
    }

}
