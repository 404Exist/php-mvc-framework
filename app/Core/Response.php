<?php

namespace App\Core;

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        $url = strtolower($url) === "back" ? $_SERVER['HTTP_REFERER'] : $url;
        header('Location: '.$url);
        exit;
    }
}
