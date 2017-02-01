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

            $table->integer('item_id')
                  ->unsigned();
            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('cascade');

            $table->integer('class_id')
                  ->unsigned();
            $table->foreign('class_id')
                  ->references('id')
                  ->on('classes')
                  ->onDelete('cascade');

            $table->integer('student_id')
                  ->unsigned()
                  ->nullable();
            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade');

            $table->integer('position_x');
            $table->integer('position_y');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('canvas_items')->insert([
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 11,
                'position_y' => 3,
                'student_id' => 1
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 12,
                'position_y' => 3,
                'student_id' => 3
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 13,
                'position_y' => 3,
                'student_id' => 2
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 14,
                'position_y' => 3,
                'student_id' => 4
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 15,
                'position_y' => 3,
                'student_id' => 5
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 11,
                'position_y' => 6,
                'student_id' => 23
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 12,
                'position_y' => 6,
                'student_id' => 20
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 13,
                'position_y' => 6,
                'student_id' => 22
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 14,
                'position_y' => 6,
                'student_id' => 24
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 15,
                'position_y' => 5,
                'student_id' => 7
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 15,
                'position_y' => 4,
                'student_id' => 6
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 15,
                'position_y' => 6,
                'student_id' => 8
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 15,
                'position_y' => 7,
                'student_id' => 9
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 15,
                'position_y' => 8,
                'student_id' => 10
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 7,
                'position_y' => 4,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 8,
                'position_y' => 4,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 9,
                'position_y' => 4,
                'student_id' => 21
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 7,
                'position_y' => 5,
                'student_id' => 18
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 8,
                'position_y' => 5,
                'student_id' => 17
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 9,
                'position_y' => 5,
                'student_id' => 19
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 7,
                'position_y' => 8,
                'student_id' => 16
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 8,
                'position_y' => 8,
                'student_id' => 13
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 9,
                'position_y' => 8,
                'student_id' => 12
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 7,
                'position_y' => 9,
                'student_id' => 14
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 8,
                'position_y' => 9,
                'student_id' => 15
            ],
            [
                'item_id'    => 1,
                'class_id'   => 1,
                'position_x' => 9,
                'position_y' => 9,
                'student_id' => 11
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 5,
                'position_y' => 5,
                'student_id' => 30
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 4,
                'position_y' => 4,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 5,
                'position_y' => 4,
                'student_id' => 38
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 4,
                'position_y' => 6,
                'student_id' => 26
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 5,
                'position_y' => 6,
                'student_id' => 37
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 7,
                'position_y' => 4,
                'student_id' => 31
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 8,
                'position_y' => 4,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 9,
                'position_y' => 4,
                'student_id' => 34
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 8,
                'position_y' => 5,
                'student_id' => 32
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 9,
                'position_y' => 5,
                'student_id' => 41
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 7,
                'position_y' => 5,
                'student_id' => 40
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 7,
                'position_y' => 8,
                'student_id' => 43
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 7,
                'position_y' => 7,
                'student_id' => 47
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 8,
                'position_y' => 7,
                'student_id' => 39
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 9,
                'position_y' => 7,
                'student_id' => 44
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 8,
                'position_y' => 8,
                'student_id' => 45
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 9,
                'position_y' => 8,
                'student_id' => 36
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 4,
                'position_y' => 8,
                'student_id' => 27
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 5,
                'position_y' => 8,
                'student_id' => 33
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 5,
                'position_y' => 7,
                'student_id' => 29
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 4,
                'position_y' => 7,
                'student_id' => 28
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 11,
                'position_y' => 4,
                'student_id' => 42
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 11,
                'position_y' => 6,
                'student_id' => 35
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 13,
                'position_y' => 4,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 15,
                'position_y' => 4,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 11,
                'position_y' => 8,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 13,
                'position_y' => 6,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 13,
                'position_y' => 8,
                'student_id' => 46
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 15,
                'position_y' => 6,
                'student_id' => 48
            ],
            [
                'item_id'    => 1,
                'class_id'   => 2,
                'position_x' => 15,
                'position_y' => 8,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 5,
                'position_y' => 1,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 7,
                'position_y' => 1,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 7,
                'position_y' => 3,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 9,
                'position_y' => 1,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 5,
                'position_y' => 3,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 9,
                'position_y' => 3,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 5,
                'position_y' => 5,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 7,
                'position_y' => 5,
                'student_id' => null
            ],
            [
                'item_id'    => 1,
                'class_id'   => 3,
                'position_x' => 9,
                'position_y' => 5,
                'student_id' => null
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