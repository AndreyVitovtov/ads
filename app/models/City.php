<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class City extends Model {
    protected $table = "cities";
    public $timestamps = false;
    public $fillable = [
        'name'
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
