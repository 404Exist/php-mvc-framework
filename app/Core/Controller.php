<?php

namespace App\Core;

use App\Core\Support\BaseMiddleware;

class Controller
{
    /**
     * @var BaseMiddleware[]
    */
    public array $middleware = [];

    public function middleware(BaseMiddleware $middleware)
    {
        $this->middleware[] = $middleware;
        return $middleware;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}