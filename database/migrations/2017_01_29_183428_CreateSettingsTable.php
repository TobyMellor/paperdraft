<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('setting_name');

            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'setting_name' => 'always_labelled'
            ],
            [
                'setting_name' => 'panel_positions'
            ],
            [
                'setting_name' => 'should_use_institution_students'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
