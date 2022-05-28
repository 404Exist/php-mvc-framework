<?php

namespace App\Core;

use App\Core\Support\QueryBuilder;

use App\Core\Support\Str;

class Model
{
    use QueryBuilder;

    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';
    protected $attributes = [];

    public function getTable(): string
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function getFillable(): array
    {
        return $this->fillable ?? [];
    }

    public function getAttributes(): array
    {
        return $this->attributes ?? [];
    }

    public function getPrimaryKeyValue()
    {
        return $this->{$this->primaryKey};
    }

    public function setPrimaryKeyValue($value)
    {
        if ($value) $this->{$this->primaryKey} = $value;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? "";
    
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function fill(array $attributes)
    {
        if (!count($attributes)) return $this;
        $this->setPrimaryKeyValue($attributes[$this->primaryKey] ?? null);
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
        return $this;
    }

    public function isFillable($key)
    {
        return in_array($key, $this->getFillable());
    }

    protected function fillableFromArray(array $attributes)
    {
        if (count($this->getFillable()) > 0) {
            return array_intersect_key($attributes, array_flip($this->getFillable()));
        }

        return $attributes;
    }

}