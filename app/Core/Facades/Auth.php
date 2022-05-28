<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Support\Auth::class;
    }
}
