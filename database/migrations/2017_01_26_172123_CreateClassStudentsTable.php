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
                ->on('students');

            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')
                ->references('id')
                ->on('classes');

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
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 2,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 3,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 4,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 5,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'F'
            ],
            [
                'student_id'               => 6,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 7,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 8,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 9,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 10,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 11,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 12,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 13,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 14,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 15,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'F'
            ],
            [
                'student_id'               => 16,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 17,
                'class_id'                 => 1,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 18,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 19,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'U'
            ],
            [
                'student_id'               => 20,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 21,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 22,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 23,
                'class_id'                 => 1,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 24,
                'class_id'                 => 1,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 25,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 26,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 27,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'U',
                'target_attainment_level'  => 'E'
            ],
            [
                'student_id'               => 28,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'G',
                'target_attainment_level'  => 'G'
            ],
            [
                'student_id'               => 29,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 30,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 31,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 32,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 33,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 34,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 35,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 36,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 37,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 38,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 39,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 40,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 41,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 42,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 43,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A*',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 44,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 45,
                'class_id'                 => 2,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 46,
                'class_id'                 => 2,
                'ability_cap'              => 'U',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'L'
            ],
            [
                'student_id'               => 47,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 48,
                'class_id'                 => 2,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 49,
                'class_id'                 => 2,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 50,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 51,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 52,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'C'
            ],
            [
                'student_id'               => 53,
                'class_id'                 => 3,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 54,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'F',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 55,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 56,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'A'
            ],
            [
                'student_id'               => 57,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'A*'
            ],
            [
                'student_id'               => 58,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'A',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 59,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'B',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 50,
                'class_id'                 => 3,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'D'
            ],
            [
                'student_id'               => 61,
                'class_id'                 => 3,
                'ability_cap'              => 'L',
                'current_attainment_level' => 'E',
                'target_attainment_level'  => 'F'
            ],
            [
                'student_id'               => 62,
                'class_id'                 => 3,
                'ability_cap'              => 'H',
                'current_attainment_level' => 'C',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 63,
                'class_id'                 => 3,
                'ability_cap'              => 'M',
                'current_attainment_level' => 'D',
                'target_attainment_level'  => 'B'
            ],
            [
                'student_id'               => 64,
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
