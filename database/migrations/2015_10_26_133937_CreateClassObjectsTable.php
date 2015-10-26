<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_objects', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('object_id')->unsigned();
            $table->foreign('object_id')
                ->references('id')
                ->on('objects');

            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')
                ->references('id')
                ->on('classes');

            $table->integer('object_position_x');
            $table->integer('object_position_y');

            $table->timestamps();
        });

        DB::table('class_objects')->insert([
            [
                'object_id' => 1,
                'class_id' => 1,
                'object_position_x' => 5,
                'object_position_y' => 10
            ],
            [
                'object_id' => 2,
                'class_id' => 1,
                'object_position_x' => 8,
                'object_position_y' => 2
            ],
            [
                'object_id' => 3,
                'class_id' => 1,
                'object_position_x' => 2,
                'object_position_y' => 1
            ],
            [
                'object_id' => 4,
                'class_id' => 1,
                'object_position_x' => 5,
                'object_position_y' => 5
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
        Schema::drop('class_objects');
    }
}
