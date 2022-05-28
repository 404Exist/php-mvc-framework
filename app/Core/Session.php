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
        $value = $this->getValueOrDefault(@$_SESSION[explode('.', $key)[0]]) ?? $this->getValueOrDefault(@$_SESSION[self::FLASH_KEY][explode('.', $key)[0]], $default);
        $keys = array_slice(explode('.', $key), 1);
        foreach ($keys as $arrKey) $value = @$value[$arrKey];
        return $value;
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

    protected function getValueOrDefault($value, $default = null)
    {
        return isset($value) ? $value : $default; 
    }

}
