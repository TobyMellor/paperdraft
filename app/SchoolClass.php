<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'class_name',
        'class_subject',
        'class_room'
    ];

    /**
     * Get the class students in a given class
     */
    public function classStudents()
    {
        return $this->hasMany(ClassStudent::class, 'class_id', 'id');
    }
}
