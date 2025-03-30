<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSpecific;
class ProductSpecificSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = Product::all();
        $sizes = ['XS', 'S', 'M', 'L', 'XL'];
        $colors = ['black', 'white', 'red', 'blue', 'green'];

        foreach ($products as $product) {
            foreach ($sizes as $size) {
                foreach ($colors as $color) {
                    ProductSpecific::create(['product_id' => $product->id, 'size' => $size, 'color' => $color]);
                }
            }
        }
    }
}
