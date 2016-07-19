<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanvasItem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'canvas_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'class_id',
        'position_x',
        'position_y',
    ];
}
