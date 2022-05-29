<?php 

namespace App\Core\Support;

use App\Models\User;

class Auth
{
    protected string $model = User::class;
    
    public function attempt($credentials)
    {
        $this->logout();
        $user = (new $this->model)->where('email', $credentials['email'])->first();
        if ($user) {
            if (password_verify($credentials['password'], $user->password)) session()->set('user', $user);
        }
        $this->check() ?: session()->flash('errors', ['password' => ['Invalid credentials']]) && redirect('back');
        return $this;
    }

    public function check()
    {
        return session()->has('user');
    }

    public function user()
    {
        return session()->get('user');
    }

    public function guest()
    {
        return !$this->check();
    }

    public function logout()
    {
        session()->forget('user');
    }

    public function setModel(string $model)
    {
        $this->model = $model;
        return $this;
    }

}