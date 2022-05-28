<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $fillable = ['email', 'firstname', 'lastname', 'password', 'status'];

    public function save($data = [])
    {
        $data['password'] = encrypt($data['password']);
        return parent::save($data);
    }
}
