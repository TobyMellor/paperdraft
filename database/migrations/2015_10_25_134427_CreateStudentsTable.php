<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('gender');
            $table->boolean('pupil_premium');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->timestamps();
        });
        
        DB::table('students')->insert([
            [
                'name' => 'Toby Mellor',
                'pupil_premium' => true,
                'gender' => 'male',
                'user_id' => 1
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
        Schema::drop('students');
    }
}
