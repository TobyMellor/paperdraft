<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'objects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_name',
        'object_width',
        'object_height',
        'object_location',
    ];
}
