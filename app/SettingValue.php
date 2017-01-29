<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingValue extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'setting_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'setting_id',
        'setting_value',
    ];

    /**
     * Get the corresponding setting name
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class, 'setting_id', 'id');
    }
}
