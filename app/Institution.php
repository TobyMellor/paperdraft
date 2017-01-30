<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institutions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'institution_code'
    ];

    /**
     * Get the users belonging to the institution
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
