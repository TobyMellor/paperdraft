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

            $table->string('title')
                  ->nullable();
            $table->string('first_name', 20)
                  ->nullable();
            $table->string('last_name', 20)
                  ->nullable();

            $table->integer('institution_id')
                  ->unsigned()
                  ->nullable();
            $table->foreign('institution_id')
                  ->references('id')
                  ->on('institutions');

            $table->integer('priviledge')
                  ->unsigned()
                  ->default(0);

            $table->string('email')->unique();
            $table->string('password', 60);
                
            $table->boolean('confirmed')
                  ->default(false);
            $table->boolean('should_change_password')
                  ->default(false);
            $table->string('confirmation_code')
                  ->nullable();

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
            [
                'email'          => 'tobymulberry@hotmail.com',
                'password'       => bcrypt('Testing123'),
                'institution_id' => 1,
                'confirmed'      => 1,
                'priviledge'     => 1
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