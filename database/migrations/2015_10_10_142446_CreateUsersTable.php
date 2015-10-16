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
            $table->string('username')->unique();
            $table->string('password', 60);

            $table->integer('year_group')->nullable();

            $table->integer('priviledge')->unsigned()->default(0);

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
            [
                'email' => 'student@toothillschool.co.uk',
                'username' => 'Student',
                'password' => bcrypt('Testing123'),
                'year_group' => '09',
                'priviledge' => 0
            ],
            [
                'email' => 'parent@toothillschool.co.uk',
                'username' => 'Parent',
                'password' => bcrypt('Testing123'),
                'year_group' => null,
                'priviledge' => 1
            ],
            [
                'email' => 'teacher@toothillschool.co.uk',
                'username' => 'Teacher',
                'password' => bcrypt('Testing123'),
                'year_group' => null,
                'priviledge' => 2
            ],
            [
                'email' => 'admin@toothillschool.co.uk',
                'username' => 'Admin',
                'password' => bcrypt('Testing123'),
                'year_group' => null,
                'priviledge' => 3
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
