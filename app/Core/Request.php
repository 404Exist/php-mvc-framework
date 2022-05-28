<?php

namespace App\Core;

use App\Core\Facades\Validator;

class Request
{
    public function __construct()
    {
    }

    public function getPath()
    {
        return $_SERVER['PATH_INFO'] ?? '/';
    }

    public function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->method() === 'GET';
    }

    public function isPost()
    {
        return $this->method() === 'POST';
    }

    public function getBody()
    {
        if ($this->method() === 'POST') {
            foreach ($_POST as $key => $value) {
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                session()->flash($key, $this->$key);
            }
        } else {
            foreach ($_GET as $key => $value) {
                $this->{$key} = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $this;
    }

    public function get($key)
    {
        return $this->$key;
    }

    public function all()
    {
        return (array) $this;
    }

    public function only(...$params)
    {
        foreach ($params as $param) {
            if (property_exists($this, $param)) {
                $data[$param] = $this->{$param};
            }
        }
        return $data;
    }

    public function validate($rules)
    {
        return Validator::validate($rules);
    }

}
