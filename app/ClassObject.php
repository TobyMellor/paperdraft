<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassObject extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'class_objects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id',
        'class_id',
        'object_position_x',
        'object_position_y',
    ];
}
