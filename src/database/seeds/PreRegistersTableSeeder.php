<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PreRegistersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pre_registers')->insert([
            [
                'email' => 'guest@guest.com',
                'token' => Str::random(250),
                'status' => 2,
                'expiration_time' => Carbon::now()->addHours(1),
            ],
            [
                'email' => 'guest2@guest2.com',
                'token' => Str::random(250),
                'status' => 2,
                'expiration_time' => Carbon::now()->addHours(1),
            ],
            [
                'email' => 'guest3@guest3.com',
                'token' => Str::random(250),
                'status' => 2,
                'expiration_time' => Carbon::now()->addHours(1),
            ],
        ]);
    }
}
