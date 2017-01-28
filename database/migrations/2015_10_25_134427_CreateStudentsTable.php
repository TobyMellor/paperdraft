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
                'name'          => 'Toby Mellor',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Bram Attwood',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Debra Fowler',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Ruby Burton',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Justin Martinez',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Joy Hansen',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Martin Garza',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Holly Foster',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Darrell Holland',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Catherine Willis',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Lucy Graves',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Troy Rhodes',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Alma Hughes',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Lisa Sanders',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Jonathan Jacobs',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Craig Howell',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Javier Sutton',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Teresa Bates',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Stacey Lowe',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Janet Campbell',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Martin Harrisonl',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Rafael Holt',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Jacob Swift',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Ava Thornton',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Owen Ingram',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Matilda Duncan',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Emily Mellor',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Kian Brooks',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Eleanor Arnold',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Holly Henry',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Sophia Bray',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Summer Peacock',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Alex Parkin',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Lydia Fleming',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Kiera Storey',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Corey Holloway',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Lucas Gardiner',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Dominic Cole',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Aimee Russell',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Mason Shah',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Freddie Johnston',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Nathan Morriss',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Ruby Parkin',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Henry Sanders',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Robert Doherty',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Sophie Hewitt',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Zachary Sanders',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Alicia Parry',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Isabella Hughes',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Jamie Brady',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Leah Bartlett',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Emily Richardson',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Isobel Talbot',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Joseph Brooks',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Millie Kemp',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Dominic Whitehouse',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Lara Patel',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Alfie Doyle',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Tia Carr',
                'pupil_premium' => false,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Aaron Morley',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Archie Griffin',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Jayden Wheeler',
                'pupil_premium' => false,
                'gender'        => 'male',
                'user_id'       => 1
            ],
            [
                'name'          => 'Charlie John',
                'pupil_premium' => true,
                'gender'        => 'female',
                'user_id'       => 1
            ],
            [
                'name'          => 'Johnathan Reynolds',
                'pupil_premium' => true,
                'gender'        => 'male',
                'user_id'       => 1
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
