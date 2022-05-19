<?php

namespace App\Core\Facades;

use App\Core\Facade;

class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Route::class;
    }
}
