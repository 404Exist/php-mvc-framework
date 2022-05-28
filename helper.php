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

if (! function_exists('class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param  string|object  $class
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (! function_exists('response')) {
  
    function response()
    {
        return new \App\Core\Response();
    }
}

if (! function_exists('request')) {
  
    function request()
    {
        return new \App\Core\Request();
    }
}

if (! function_exists('abort')) {
  
    function abort($code)
    {
        response()->setStatusCode($code);
        try {
            return view("errors.$code");
        } catch(\Exception $e) {
            throw new \Exception("Error $code", $code);
        }
    }
}

if (! function_exists('encrypt')) {
  
    function encrypt($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

if (! function_exists('redirect')) {
    function redirect(string $url)
    {
       return response()->redirect($url);
    }
}

if (! function_exists('session')) {
    function session()
    {
       return new \App\Core\Session();
    }
}

if (! function_exists('auth')) {
    function auth()
    {
       return new \App\Core\Support\Auth();
    }
}

if (! function_exists('old')) {
    function old($key, $default = null)
    {
       return session()->get($key, $default);
    }
}