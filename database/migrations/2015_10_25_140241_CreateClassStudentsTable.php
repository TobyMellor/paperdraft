<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_students', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')
                ->references('id')
                ->on('users');

            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')
                ->references('id')
                ->on('classes');

            $table->string('current_attainment_level');
            $table->string('target_attainment_level');

            $table->timestamps();
        });

        DB::table('class_students')->insert([
            [
                'student_id' => 1,
                'class_id' => 1,
                'current_attainment_level' => 'A',
                'target_attainment_level' => 'A*'
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
        Schema::drop('class_students');
    }
}
