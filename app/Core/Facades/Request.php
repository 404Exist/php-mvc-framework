<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Request extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Request::class;
    }
}
