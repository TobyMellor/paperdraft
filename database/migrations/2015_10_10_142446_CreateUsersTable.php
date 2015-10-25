<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email')->unique();
            $table->string('password', 60);

            $table->integer('priviledge')
                ->unsigned()
                ->default(0);

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
            [
                'email' => 'tobymulberry@hotmail.com',
                'password' => bcrypt('Testing123')
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
        Schema::drop('users');
    }
}
