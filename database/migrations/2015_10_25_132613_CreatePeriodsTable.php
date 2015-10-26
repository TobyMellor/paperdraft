<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->increments('id');

            $table->string('period_day');
            $table->string('period_start', 4);
            $table->string('period_end', 4);

            $table->timestamps();
        });

        $weekdays = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday'
        ];

        $periodTimes = [
            '0825' => '0845',
            '0845' => '0930',
            '0930' => '1015',
            '1015' => '1100',
            '1115' => '1200',
            '1200' => '1240',
            '1240' => '1325',
            '1325' => '1410',
            '1410' => '1450',
            '1450' => '1530'
        ];

        $periods = [];

        foreach($weekdays as $weekday) {
            foreach($periodTimes as $periodStart => $periodEnd) {    
                array_push($periods, [
                    'period_day' => $weekday,
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd
                ]);
            }
        }
        
        DB::table('periods')->insert($periods);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('periods');
    }
}
