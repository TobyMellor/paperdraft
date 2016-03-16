<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');

            $table->string('object_name');

            $table->integer('object_width');
            $table->integer('object_height');

            $table->string('object_location');

            $table->timestamps();
        });

        DB::table('objects')->insert([
            [
                'object_name' => 'Student Desk',
                'object_width' => 32,
                'object_height' => 32,
                'object_location' => 'desk.png'
            ],
            [
                'object_name' => 'Sofa',
                'object_width' => 32,
                'object_height' => 32,
                'object_location' => 'sofa-1.png'
            ],
            [
                'object_name' => 'Chair',
                'object_width' => 32,
                'object_height' => 32,
                'object_location' => 'chair-1.png'
            ],
            [
                'object_name' => 'Teacher Desk',
                'object_width' => 64,
                'object_height' => 32,
                'object_location' => 'teacher-desk-1.png'
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
        Schema::drop('objects');
    }
}
