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
                
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_code')->nullable();

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
            [
                'email' => 'tobymulberry@hotmail.com',
                'password' => bcrypt('Testing123'),
                'confirmed' => 1
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