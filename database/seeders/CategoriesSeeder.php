<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            ['name'=> 'Men', 'description'=> 'Clothes for Men'],
            ['name'=> 'Women', 'description'=> 'Clothes for Women'],
            ['name'=> 'Kids', 'description'=> 'Clothes for Kids']
        ]);
    }
}
