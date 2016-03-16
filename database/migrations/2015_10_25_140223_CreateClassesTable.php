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

            $table->timestamps();
        });

        DB::table('classes')->insert([
            [
                'user_id' => 1,
                //'period_id' => 1,
                'class_name' => 'Year 11'
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
