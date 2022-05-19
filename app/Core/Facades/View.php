<?php

namespace App\Core\Facades;

use App\Core\Facade;

class View extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\View::class;
    }
}
