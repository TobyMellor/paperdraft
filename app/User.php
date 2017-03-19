<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'password',
        'confirmation_code',
        'institution_name',
        'user_preferences'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'confirmation_code'];
    
    /**
     * The soft delete attribute
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the corresponding institution
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id', 'id');
    }

    /**
     * Get the corresponding classes
     */
    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class, 'user_id', 'id');
    }
}
