<?php

namespace App\Core;

class Route
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return view('errors.404');
        }
        if (is_string($callback)) {
            return view($callback);
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        $next = function() use ($callback) {$callback[0]->{$callback[1]}($this->request->getBody());};
        foreach ($callback[0]->getMiddleware() as $middleware) {
            if ($middleware->willApplyTo($callback[1])) return $middleware->handle($next);
        }
        return $next();
    }

}
