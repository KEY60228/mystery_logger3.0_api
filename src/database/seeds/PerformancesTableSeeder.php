<?php

use Illuminate\Database\Seeder;

class PerformancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('performances')->insert([[
            'product_id' => 1,
            'venue_id' => 1,
            'active_id' => 1,
        ], [
            'product_id' => 2,
            'venue_id' => 2,
            'active_id' => 1,
        ], [
            'product_id' => 3,
            'venue_id' => 3,
            'active_id' => 1,
        ], [
            'product_id' => 4,
            'venue_id' => 4,
            'active_id' => 1,
        ], [
            'product_id' => 5,
            'venue_id' => 5,
            'active_id' => 1,
        ]]);
    }
}
