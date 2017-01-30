<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 50);

            $table->string('institution_code')
                  ->unique();

            $table->timestamps();
        });
        
        DB::table('institutions')->insert([
            [
                'name' => 'Loughborough University',
                'institution_code' => 'aG42hD'
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
        Schema::drop('institutions');
    }
}