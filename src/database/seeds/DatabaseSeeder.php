<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PreRegistersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(OrganizersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(VenuesTableSeeder::class);
        $this->call(PerformancesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
    }
}
