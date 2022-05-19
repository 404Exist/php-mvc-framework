<?php
if (!function_exists('dump')) {
    function dump(...$dumps)
    {
        foreach ($dumps as $dump) {
            echo '<pre>';
            print_r($dump);
            echo '</pre>';
        }
    }
}

if (!function_exists('dd')) {
    function dd(...$dumps)
    {
        dump(...$dumps);
        die(1);
    }
}

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        return \App\Core\Facades\View::view($view, $data);
    }
}

if (!function_exists('config')) {
    function config($file)
    {
        return \App\Core\Facades\Config::config($file);
    }
}

if (!function_exists('storage_path')) {
    function storage_path($file = '')
    {
        return __DIR__ . '/storage/' . $file;
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return \App\Core\Facades\Config::env($key, $default);
    }
}
