<?php

namespace App\Core;

class Application
{

    public Route $route;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->route = new Route($this->request, $this->response);

        $this->db = new Database();
    }

    public function run()
    {
        echo $this->route->resolve();
    }
}
