<?php

namespace App\Core;

abstract class Facade
{

    protected static $data = [];

    public function __construct(...$data)
    {
        static::$data = $data;
    }

    public static function __callStatic($name, $arguments)
    {
        return (new (static::getFacadeAccessor())(...static::$data))->$name(...$arguments);
    }

    public function __call($name, $arguments)
    {
        return (new (static::getFacadeAccessor())(...static::$data))->$name(...$arguments);
    }

    abstract protected static function getFacadeAccessor();
}
