<?php

use Illuminate\Database\Seeder;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Model;
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        // $this->call(UsersTableSeeder::class);
=======
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        Model::reguard();
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
    }
}
