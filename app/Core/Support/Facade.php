<?php

namespace App\Core\Support;

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

    // public function __get($name)
    // {
    //     return (new (static::getFacadeAccessor())(...static::$data))->$name;
    // }

    // public function __set($name, $value)
    // {
    //     static::$data[$name] = $value;
    // }

    abstract protected static function getFacadeAccessor();
}
