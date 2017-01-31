<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'class_rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name'
    ];

    /**
     * Get the class students in a given class
     */
    public function schoolClass()
    {
        return $this->hasMany(SchoolClass::class, 'class_id', 'id');
    }
}
