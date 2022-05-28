<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Response extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Response::class;
    }
}
