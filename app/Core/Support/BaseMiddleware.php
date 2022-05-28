<?php 

namespace App\Core\Support;

abstract class BaseMiddleware
{
    protected array $only = [];
    protected array $except = [];

    abstract public function handle($next);

    public function only(...$methods)
    {
        $this->only = $methods;
    }

    public function except(...$methods)
    {
        $this->except = $methods;
    }

    public function willApplyTo(string $method) :bool
    {
        if (empty($this->only) && empty($this->except)) return true;
        if (in_array($method, $this->only) || (!empty($this->except) && !in_array($method, $this->except))) return true;
        return false;
    }
}