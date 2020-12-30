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
            [
                'pre_register_id' => 4,
                'account_id' => 'guest4',
                'name' => 'GUEST4',
                'email' => 'guest4@guest4.com',
                'password' => Hash::make('guest4guest4'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 5,
                'account_id' => 'guest5',
                'name' => 'GUEST5',
                'email' => 'guest5@guest5.com',
                'password' => Hash::make('guest5guest5'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 6,
                'account_id' => 'guest6',
                'name' => 'GUEST6',
                'email' => 'guest6@guest6.com',
                'password' => Hash::make('guest6guest6'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 7,
                'account_id' => 'guest7',
                'name' => 'GUEST7',
                'email' => 'guest7@guest7.com',
                'password' => Hash::make('guest7guest7'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 8,
                'account_id' => 'guest8',
                'name' => 'GUEST8',
                'email' => 'guest8@guest8.com',
                'password' => Hash::make('guest8guest8'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 9,
                'account_id' => 'guest9',
                'name' => 'GUEST9',
                'email' => 'guest9@guest9.com',
                'password' => Hash::make('guest9guest9'),
                'image_name' => '/storage/user_img/default.jpeg',
            ], 
            [
                'pre_register_id' => 10,
                'account_id' => 'guest10',
                'name' => 'GUEST10',
                'email' => 'guest10@guest10.com',
                'password' => Hash::make('guest10guest10'),
                'image_name' => '/storage/user_img/default.jpeg',
            ],
        ]);
    }
}
