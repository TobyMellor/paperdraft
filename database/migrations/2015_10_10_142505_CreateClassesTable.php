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

            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');

            $table->string('class_name');

            $table->timestamps();
        });

        DB::table('classes')->insert([
            [
                'teacher_id' => 2,
                'subject_id' => 1,
                'class_name' => 'History H5'
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
