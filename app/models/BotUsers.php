<?php


namespace App\models;


use Illuminate\Database\Eloquent\Model;

class BotUsers extends Model {
    protected $table = "users";
    public $timestamps = false;
    public $fillable = [
        'id',
        'chat',
        'username',
        'first_name',
        'last_name',
        'country',
        'messenger',
        'access',
        'date',
        'time',
        'active',
        'start',
        'count_ref',
        'access_free',
        'language'
    ];

    public function ads() {
        return $this->hasMany(Ad::class, 'users_id');
    }

    public function ref() {
        return $this->hasMany(RefSystem::class, 'referrer');
    }

}
