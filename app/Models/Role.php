<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name','created_at','updated_at'
    ];

    public function users()
    {
      return $this->belongToMany(User::class, 'role_user');
    }
}
