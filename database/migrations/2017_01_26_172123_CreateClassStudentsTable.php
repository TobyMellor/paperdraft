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

            $table->integer('student_id')
                  ->unsigned();
            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade');

            $table->integer('user_id')
                  ->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->integer('class_id')
                  ->unsigned();
            $table->foreign('class_id')
                  ->references('id')
                  ->on('classes')
                  ->onDelete('cascade');

            $table->string('ability_cap');
            $table->string('current_attainment_level')
                  ->nullable();
            $table->string('target_attainment_level')
                  ->nullable();

            $table->timestamps();
        });

        DB::table('class_students')->insert([
            [
                'student_id'               => 1,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 2,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 3,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 4,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 5,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'F'
            ],
            [
                'student_id'               => 6,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 7,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 8,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 9,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 10,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 11,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 12,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 13,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 14,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 15,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'F'
            ],
            [
                'student_id'               => 16,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 17,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 18,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 19,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'U'
            ],
            [
                'student_id'               => 20,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 21,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 22,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 23,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 24,
                'user_id'                  => 1,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 25,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 26,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 27,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'E'
            ],
            [
                'student_id'               => 28,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'G',
                'target_attainment_level'  => 'G'
            ],
            [
                'student_id'               => 29,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 30,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 31,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 32,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 33,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 34,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 35,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 36,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 37,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 38,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 39,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 40,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 41,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 42,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 43,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 44,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 45,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 46,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'U',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'L'
            ],
            [
                'student_id'               => 47,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 48,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 49,
                'user_id'                  => 1,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 50,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 51,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 52,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 53,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 54,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 55,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 56,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 57,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 58,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 59,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 60,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 61,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'F'
            ],
            [
                'student_id'               => 62,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 63,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 64,
                'user_id'                  => 1,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'A*'
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
