<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->integer('width');
            $table->integer('height');

            $table->string('location');

            $table->timestamps();
        });

        DB::table('items')->insert([
            [
                'name' => 'Student Desk',
                'width' => 32,
                'height' => 32,
                'location' => 'desk.png'
            ],
            [
                'name' => 'Sofa',
                'width' => 32,
                'height' => 32,
                'location' => 'sofa-1.png'
            ],
            [
                'name' => 'Chair',
                'width' => 32,
                'height' => 32,
                'location' => 'chair-1.png'
            ],
            [
                'name' => 'Teacher Desk',
                'width' => 64,
                'height' => 32,
                'location' => 'teacher-desk-1.png'
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
        Schema::drop('items');
    }
}
