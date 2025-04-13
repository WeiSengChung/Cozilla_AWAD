<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductSpecificSeeder;
use Database\Seeders\UserProfileSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(ProductSeeder::class);
        $this->call(ProductSpecificSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserProfileSeeder::class);
        $this->call(ContactUsSeeder::class);
    }
}
