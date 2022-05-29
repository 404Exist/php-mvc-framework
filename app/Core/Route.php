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
        $callback = $this->routes[$this->request->method()][$this->request->getPath()] ?? false;
        if ($callback === false) return abort(404);
        if (is_string($callback)) return view($callback);
        if (is_array($callback)) {
            $callback[0] = new $callback[0];
            foreach ($callback[0]->getMiddleware() as $middleware) {
                if ($middleware->willApplyTo($callback[1])) return $middleware->handle(function() use ($callback) {call_user_func($callback, $this->request->getBody());});
            }
        }
        return call_user_func($callback, $this->request->getBody());
    }

}
