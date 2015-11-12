<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'class_students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'current_attainment_level',
        'target_attainment_level'
    ];
}
