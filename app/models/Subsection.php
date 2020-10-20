<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Subsection extends Model {
    protected $table = "subsections";
    protected $with = ['rubric'];
    public $timestamps = false;
    public $fillable = [
        'name',
        'rubrics_id'
    ];

    public function rubric() {
        return $this->belongsTo(Rubric::class, 'rubrics_id');
    }

    public function ads() {
        return $this->hasMany(Ad::class, 'subsection_id');
    }
}
