<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model {
    protected $table = "rubrics";
    public $timestamps = false;
    public $fillable = [
        'name'
    ];

    public function subsections() {
        return $this->hasMany(Subsection::class, 'rubrics_id');
    }
}
