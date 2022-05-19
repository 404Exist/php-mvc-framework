<?php

namespace App\Core\Facades;

use App\Core\Facade;

class Request extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Request::class;
    }
}
