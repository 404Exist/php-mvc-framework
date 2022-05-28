<?php
namespace App\Middleware;

use App\Core\Support\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public function handle($next)
    {
        if (auth()->guest()) return abort(403);
        return $next();
    }
}