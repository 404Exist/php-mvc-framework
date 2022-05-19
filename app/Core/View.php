<?php

namespace App\Core;

class View
{
    protected $cache_path;
    protected $cached_file;
    protected $cache_enabled = false;
    protected TemplateEngine $template;

    public function __construct()
    {
        $this->template = new TemplateEngine();
        $this->cache_path = storage_path('cache/');
    }

    public function view($file, $data = [])
    {
        $this->cached_file = $this->cache_path . str_replace('/', '_', $file . '.php');
        $this->cache($file);
        extract($data, EXTR_SKIP);
        require $this->cached_file;
    }

    protected function cache($file)
    {
        if (!file_exists($this->cache_path)) {
            mkdir($this->cache_path, 0744);
        }

        if ($this->shouldCreate($file)) {
            $this->create($file);
        }

    }

    protected function shouldCreate($file)
    {
        return !$this->cache_enabled || !file_exists($this->cached_file) || filemtime($this->cached_file) < filemtime($file);
    }

    protected function create($file)
    {
        $code = $this->template->compile($file);
        file_put_contents($this->cached_file, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
    }
}
