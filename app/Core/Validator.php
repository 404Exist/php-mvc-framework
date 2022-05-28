<?php

namespace App\Core;

use App\Core\Facades\Request;

class Validator
{
    protected DB $db;
    protected array $rules = [];
    protected array $attributes = [];
    protected array $errors = [];

    public function __construct()
    {
        $this->db = new DB();
        foreach(Request::getBody() as $key => $value) 
            $this->attributes[$key] = $value;
    }

    public function validate($rules)
    {
        foreach ($this->rules($rules) as $attribute => $rules) {
            $value = $this->attributes[$attribute];
            foreach ($rules as $rule) {
                @list($rule, $param) = explode(':', $rule);
                $method = 'validate' . ucfirst($rule);
                if (!$this->$method($value, $param, $attribute)) {
                    $this->pushErrors($attribute, $rule, $param);
                }
            }
        }
        return $this->passes() ? true : redirect('back');
    }

    public function errors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getError($attribute)
    {
        return $this->errors[$attribute] ?? [];
    }

    public function hasError($attribute)
    {
        return !empty($this->errors[$attribute]);
    }

    protected function validateRequired($value)
    {
        return !empty($value);
    }

    protected function validateString($value)
    {
        return is_string($value);
    }

    protected function validateMax($value, $max)
    {
        return strlen($value) <= $max;
    }

    protected function validateMin($value, $min)
    {
        return strlen($value) >= $min;
    }

    protected function validateEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function validateSame($value, $field)
    {
        return $value === $this->attributes[$field];
    }
    
    protected function validateUnique($value, $table, $attribute)
    {
        return !$this->db->query("SELECT * FROM `{$table}` WHERE `$attribute` = '$value' ")->rowCount();
    }

    protected function rules($rules)
    {
        foreach ($rules as $key => $value) {
            if (!is_array($value)) {
                $value = explode('|', $value);
            }

            $this->rules[$key] = $value;
        }
        return $this->rules;
    }

    protected function pushErrors($attribute, $rule, $param)
    {
        $message = config('validate')[$rule] ?? $rule;
        $this->errors[$attribute][] = str_replace(
            [':attribute', ":$rule", ":other"],
            [$this->beautify($attribute), $param, $this->beautify($param)],
            $message
        );
       session()->flash('errors', $this->errors);
    }

    protected function beautify($attribute)
    {
        return ucwords(str_replace('_', ' ', $attribute));
    }

    protected function passes()
    {
        return empty($this->errors);
    }
}
