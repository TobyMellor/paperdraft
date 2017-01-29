<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting_name',
    ];

    /**
     * Get the corresponding setting name
     */
    public function settingValue()
    {
        return $this->hasMany(SettingValue::class, 'setting_id', 'id');
    }
}
