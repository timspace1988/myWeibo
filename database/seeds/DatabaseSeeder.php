<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

//use UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');
        $this->call('StatusesTableSeeder');
        $this->call('FollowingsFollowersTableSeeder');

        Model::reguard();
    }
}
