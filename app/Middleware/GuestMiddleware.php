<?php
namespace App\Middleware;

use App\Core\Support\BaseMiddleware;

class GuestMiddleware extends BaseMiddleware
{
    public function handle($next)
    {
        if (auth()->user()) redirect('/profile');
        return $next();
    }
}