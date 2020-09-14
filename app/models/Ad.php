<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model {
    protected $table = "ads";
    public $timestamps = false;
    public $fillable = [
        'title',
        'description',
        'photo',
        'phone',
        'cities_id',
        'users_id',
        'subsection_id',
        'active',
        'date',
        'time',
        'admin_id',
        'grabber'
    ];

    public function city() {
        return $this->belongsTo(City::class, 'cities_id');
    }

    public function user() {
        return $this->belongsTo(BotUsers::class, 'users_id');
    }

    public function subsection() {
        return $this->belongsTo(Subsection::class, 'subsection_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
