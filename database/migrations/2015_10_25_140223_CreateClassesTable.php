<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            /*
            $table->integer('period_id')->unsigned();
            $table->foreign('period_id')
                ->references('id')
                ->on('periods');
            */

            $table->string('class_name');
            $table->integer('canvas_action_undo_count')
                  ->unsigned()
                  ->default(1);

            $table->string('class_subject', 30)
                  ->nullable();
            $table->string('class_room', 30)
                  ->nullable();

            $table->timestamps();
        });

        DB::table('classes')->insert([
            [
                'user_id'       => 1,
                'class_name'    => 'Year 11',
                'class_subject' => 'Mathematics',
                'class_room'    => 'Room 101'
            ],
            [
                'user_id'       => 1,
                'class_name'    => 'Year 12',
                'class_subject' => 'Mathematics',
                'class_room'    => 'Room 102'
            ],
            [
                'user_id'       => 1,
                'class_name'    => 'Year 13',
                'class_subject' => 'ICT',
                'class_room'    => 'Room 101'
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
        Schema::drop('classes');
    }
}
