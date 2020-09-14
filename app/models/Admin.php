<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
    protected $table = "admin";
    public $timestamps = false;
    public $fillable = [
        'login',
        'password',
        'name',
        'language',
        'role_id'
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'roles_id');
    }
}
