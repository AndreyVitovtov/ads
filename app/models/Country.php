<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    protected $table = "country";
    public $timestamps = false;
    public $fillable = [
        'name'
    ];

    public function cities() {
        return $this->hasMany(City::class, 'country_id');
    }
}
