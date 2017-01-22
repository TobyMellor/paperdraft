<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanvasHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvas_history', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

            $table->integer('canvas_item_id')->unsigned();
            $table->foreign('canvas_item_id')
                ->references('id')
                ->on('canvas_items')
                ->onDelete('cascade');

            $table->string('type');

            $table->integer('position_x')->nullable();
            $table->integer('position_y')->nullable();
            $table->integer('previous_position_x');
            $table->integer('previous_position_y');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('canvas_history');
    }
}
