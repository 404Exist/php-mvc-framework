<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Session extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Session::class;
    }
}
