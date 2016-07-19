<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanvasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvas_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')
                ->references('id')
                ->on('items');

            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')
                ->references('id')
                ->on('classes');

            $table->integer('position_x');
            $table->integer('position_y');

            $table->timestamps();
        });

        DB::table('canvas_items')->insert([
            [
                'item_id' => 1,
                'class_id' => 1,
                'position_x' => 5,
                'position_y' => 10
            ],
            [
                'item_id' => 2,
                'class_id' => 1,
                'position_x' => 8,
                'position_y' => 2
            ],
            [
                'item_id' => 3,
                'class_id' => 1,
                'position_x' => 2,
                'position_y' => 1
            ],
            [
                'item_id' => 4,
                'class_id' => 1,
                'position_x' => 5,
                'position_y' => 5
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('canvas_items');
    }
}
