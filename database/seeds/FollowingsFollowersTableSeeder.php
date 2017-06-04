<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowingsFollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //get all users' id except first user
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //let first user to follow all other users
        $user->follow($follower_ids);

        //all other users follow first user
        foreach($followers as $follower){
            $follower->follow($user_id);
        }
    }
}
