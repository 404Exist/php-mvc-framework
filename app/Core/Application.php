<?php

namespace App\Core;

class Application
{
    public Route $route;
    public Request $request;
    public Response $response;
    public Session $session;
    public DB $db;
    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->route = new Route($this->request, $this->response);

        $this->db = new DB();
    }

    public function run()
    {
        try {
            session_start(); 
            echo $this->route->resolve();
            $this->session->unsetFlashes();
        } catch (\Exception $e) {
            return view('errors.any', ['error' => $e]);
        }
    }   
}
