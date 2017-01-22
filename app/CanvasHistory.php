<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanvasHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'canvas_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'canvas_item_id',
        'class_id',
        'type',
        'position_x',
        'position_y',
        'previous_position_x',
        'previous_position_y'
    ];
}
