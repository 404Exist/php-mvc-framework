<?php

namespace App\Core\Support;

class TemplateEngine
{
    protected $sections = [];
    protected $views_path = __DIR__ . "/../../../resources/views/";

    public function compile($code)
    {
        $code = $this->extends($code);
        $code = $this->section($code);
        $code = $this->yield($code);
        $code = $this->error($code);
        $code = $this->auth($code);
        $code = $this->guest($code);
        $code = $this->comment($code);
        $code = $this->echos($code);
        $code = $this->escapedEchos($code);
        return $this->php($code);
    }

    function extends ($extend) {
        $code = $this->fileContent($extend);
        preg_match_all('/@(extends|include)\((.*?)\)/i', $code, $extends, PREG_SET_ORDER);
        foreach ($extends as $extend) {
            $code = str_replace($extend[0], $this->extends($extend[2]), $code);
        }
        return preg_replace('/@(extends|include)\((.*?)\)/i', '', $code);
    }

    protected function fileSrc($file)
    {
        $file = preg_replace('/\\\|\./', '/', $file);
        $file = preg_replace('/\"|\'/', '', $file);
        return "{$this->views_path}$file.blade.php";
    }

    protected function fileContent($view)
    {
        $file = $this->fileSrc($view);
        if (file_exists($file)) {
            return file_get_contents($file);
        }

        throw new \Exception("$view view not found", 404);
    }

    protected function section($code)
    {
        preg_match_all('/@section\((.*?)\)(.*?)@endsection/is', $code, $sections, PREG_SET_ORDER);
        foreach ($sections as $section) {
            $this->sections[$section[1]] = $section[2];
            $code = str_replace($section[0], '', $code);
        }
        return $code;
    }
    function yield ($code) {
        foreach ($this->sections as $section => $value) {
            $code = preg_replace(' /@yield\((' . $section . ')\)/', $value, $code);
        }
        return preg_replace('/@yield\((.*?)\)/i', '', $code);
    }
    protected function comment($code)
    {
        return preg_replace('~\{{--\s*(.+?)\s*\--}}~is', '', $code);
    }
    protected function php($code)
    {
        return preg_replace('~\@php\s*(.+?)\s*\@endphp~is', '<?php $1 ?>', $code);
    }
    protected function error($code)
    {
        preg_match_all('/@error\((.*?)\)(.*?)@enderror/is', $code, $errors, PREG_SET_ORDER);
        $sessionMessages = session()->get('errors');
        foreach ($errors as $error) {
            $key = str_replace("'", '', $error[1]);
            $errorMessage = @$sessionMessages[$key][0] ? str_replace('$message', $sessionMessages[$key][0], $error[2]) : "";
            $code = str_replace($error[0], $errorMessage, $code);
        }
        return $code;
    }
    protected function auth($code)
    {
        preg_match_all('/@auth(.*?)@endauth/is', $code, $auths, PREG_SET_ORDER);
        foreach ($auths as $auth) {
            $content = "";
            if (auth()->user()) $content = $auth[1];
            $code = str_replace($auth[0], $content, $code);
        }
        return $code;
    }

    protected function guest($code)
    {
        preg_match_all('/@guest(.*?)@endguest/is', $code, $guests, PREG_SET_ORDER);
        foreach ($guests as $guest) {
            $content = "";
            if (auth()->guest()) $content = $guest[1];
            $code = str_replace($guest[0], $content, $code);
            
        }
        return $code;
    }

    protected function echos($code)
    {
        return preg_replace('~\{!!\s*(.+?)\s*\!!}~is', '<?php echo $1 ?>', $code);
    }
    protected function escapedEchos($code)
    {
        return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
    }

}
