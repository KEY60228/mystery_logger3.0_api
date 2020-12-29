<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'pre_register_id' => 1,
                'account_id' => 'guest',
                'name' => 'GUEST',
                'email' => 'guest@guest.com',
                'password' => Hash::make('guestguest'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 2,
                'account_id' => 'guest2',
                'name' => 'GUEST2',
                'email' => 'guest2@guest2.com',
                'password' => Hash::make('guest2guest2'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 3,
                'account_id' => 'guest3',
                'name' => 'GUEST3',
                'email' => 'guest3@guest3.com',
                'password' => Hash::make('guest3guest3'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
        ]);
    }
}
