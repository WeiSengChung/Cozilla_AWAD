<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $clothes_category = [
            'Men' => [
                'top' => [
                    't_shirt' => ["price" => 59.90, "items" => ["Bold Stripes T-shirt", "Classic Creeeck T-shirt", "Urban Essentials T-shirt", "Vintage Cotton T-shirt", "Everyday Comfort T-shirt"]],
                    'long_sleeve' => ["price" => 47.90, "items" => ["Classic Henley", "Thermal Knit Long Sleeve", "Slim Fit Pullover", "WInter Warmth Long Sleeve", "Essential Layering Top"]],
                    'hoodies' => ["price" => 79.90, "items" => ["Urban Comfort Hoodie", "Classic Zip-Up Hoodie", "Relaxed Fit Hoodie", "Adventure Pullover Hoodie", "Cozy Fleece Hoodie"]],
                    'sweatshirt' => ["price" => 69.90, "items" => ["Vintage Crewneck Sweatshirt", "Rugged Outdoor Sweatshirt", "Comfy Cotton Sweatshirt", "Retro Sport Sweatshirt", "Casual Fleece Sweatshirt"]],
                    'ut' => ["price" => 125.90, "items" => ["Retro Graphic T-shirt", "Pop Culture Print T-shirt", "Street Style Graphic t-shirt", "Artistic Expression T-shirt", "Bold Statement T-shirt"]]
                ],
                'bottom' => [
                    "jeans" => ["price" => 59.90, "items" => ["Slim Fit Denim", "Classic Staright Leg Jeans", "Distressed Denim Jeans", "Vintage Wash Jeans", "Stretch Comfort Jeans"]],
                    "long_pants" => ["price" => 75.90, "items" => ["City Cargo Pants", "Slim Fit Long Pants", "tailored Joggers", "relaxed Ft Cotton Pants", "tech Stretch Pants"]],
                    "shorts" => ["price" => 88.90, "items" => ["Sporty Cargo Shorts", "Classic Denim Short", "Athletic Mesh Shorts", "Relaxed Fit Chino Shorts", "Lightweight Summer Shorts"]],
                    "chinos" => ["price" => 47.90, "items" => ["Tailored Chino ", "Classic Stretch Chinos", "SLim Fot Chino Pants", "Cotton Twill Chinos", "Flat-Front Chino Pants"]],
                    "ankle_pants" => ["price" => 35.90, "items" => ["Modern Fit Ankle Pants", "Slim Stretch Ankle pants", "Cropped Casual Pants", "tailored Stretch Ankle Pants", "Minimalist Ankle"]]
                ]
            ],
            'Women' => [
                'top' => [
                    't_shirt' => ["price" => 59.90, "items" => ["Flowy V-Nec", "Relaxed Fit Crewneck T-shirt", "Classic Cotton T-shirt", "Soft Modal t-shirt", "Feminine Fit T-shirt"]],
                    'long_sleeve' => ["price" => 50.90, "items" => ["Elegant Ribbed Top", "Cozy Knit Long Sleeve", "Lightweight Layering Top", "Classic Scoop Neck Long Sleeve", "Stretch Cotton Long Sleeve"]],
                    'hoodies' => ["price" => 85.90, "items" => ["Cozy Zip-Up Hoodie", "Chic Pullover Hoodie", "Relaxed Fit Hoodie", "Everyday Essential Hoodie", "Soft Fleece Hoodie"]],
                    'sweatshirt' => ["price" => 59.90, "items" => ["Comfy Oversized Sweatshirt", "Classic Crewneck Sweatshirt", "Lightweight Pullover Sweatshirt", "Cozy Cotton Sweatshirt", "Vintage-Inspired Sweatshirt"]],
                    'blouses' => ["price" => 97.90, "items" => ["Silky Button-Down Blouse", "Chiffon Ruffle Blouse", "Elegant Wrap Blouse", "Boho Floral Blouse", "Tailored Office Blouse"]]
                ],
                'bottom' => [
                    "shorts" => ["price" => 49.90, "items" => ["Casual High-Waist Shorts", "Denim Cut-Off Shorts", "Relaxed Fit Linen Shorts", "Tailored Chino Shorts", "Athletic Mesh Shorts"]],
                    "jeans" => ["price" => 59.90, "items" => ["Skinny Fit Stretch Jeans", "High-Rise Vintage Jeans", "Wide Leg Denim", "Distressed Skinny Jeans", "Classic Straight-Leg Jeans"]],
                    "casual_pants" => ["price" => 65.90, "items" => ["Relaxed Fit Lounge Pants", "Drawstring Jogger Pants", "Wide-Leg Palazzo Pants", "Lightweight Cotton Pants", "Tapered Leg Pants"]],
                    "long_pants" => ["price" => 47.90, "items" => ["Tapered Leg Trousers", "Slim Fit Dress Pants", "Wide-Leg Ankle Pants", "Tailored Office Trousers", "Stretch Slim Fit Pants"]],
                    "legging" => ["price" => 40.90, "items" => ["Activewear High-Rise Leggings", "Seamless Yoga Leggings", "Fleece-Lined Winter Leggings", "Sculpting Compression Leggings", "Printed Performance Leggings"]]
                ]
            ],
            'Kids' => [
                'top' => [
                    't_shirt' => ["price" => 35.90, "items" => ["Fun Graphic Tee", "Rainbow Print Tee", "Animal Friends Tee", "Colorful Stripes Tee", "Dino Adventure T-shirt"]],
                    'long_sleeve' => ["price" => 64.90, "items" => ["Playtime Long Sleeve", "Warm Cotton Long Sleeve", "Adventure Ready Long Sleeve", "Striped Cozy Top", "Cartoon Print Long Sleeve"]],
                    'hoodies' => ["price" => 73.90, "items" => ["Adventure Pullover Hoodie", "Fun Print Zip-Up Hoodie", "Cozy Fleece Hoodie", "Bold Colors Hoodie", "Playground Favorite Hoodie"]],
                    'sweatshirt' => ["price" => 89.90, "items" => ["Cozy Graphic Sweatshirt", "Cool Weather Pullover", "Playground Fun Sweatshirt", "Playground Fun Sweatshirt", "Comfy Crewneck Sweatshirt"]],
                    'ut' => ["price" => 119.90, "items" => ["Cartoon Print Tee", "Superhero Graphic Tee", "Animal Kingdom Tee", "Space Explorer T-shirt", "Rainbow Adventure Tee"]],
                ],
                'bottom' => [
                    "jeans" => ["price" => 58.90, "items" => ["Rugged Stretch Jeans", "Comfy Elastic Waist Jeans", "Adventure-Ready Denim", "Relaxed Fit Jeans", "Classic Straight Leg Jeans"]],
                    "long_pants" => ["price" => 70.90, "items" => ["Explorer Cargo Pants", "Elastic Waist Jogger Pants", "Cozy Knit Pants", "Durable Playtime Pants", "Slim Fit Adventure Pants"]],
                    "shorts" => ["price" => 60.90, "items" => ["Playground Ready Shorts", "Comfy Cotton Shorts", "Bold Colors Cargo Shorts", "Lightweight Summer Shorts", "Activewear Running Shorts"]],
                    "chinos" => ["price" => 39.90, "items" => ["Smart Kid Chinos", "Elastic Waist Chino Pants", "Classic Fit Chino Shorts", "Durable School Chinos", "Tailored Fit Chino Pants"]],
                    "jogger" => ["price" => 48.90, "items" => ["Comfy Drawstring Joggers", "Adventure Stretch Joggers", "Elastic Waist Joggers", "Warm Fleece Joggers", "Playground Ready Joggers"]]
                ]
            ],
        ];

        foreach ($clothes_category as $genderKey => $gender) {
            foreach ($gender as $top_or_bottom_key => $topOrBottom) {
                foreach ($topOrBottom as $clothesCategoryKey => $clothesCategories) {
                    foreach ($clothesCategories['items'] as $clotheName) {
                        Product::create([
                            'name' => $clotheName,
                            'description'=>'👍',
                            'price' => $clothesCategories['price'],
                            'gender_category' => $genderKey,
                            'top_bottom_category' => $top_or_bottom_key,
                            'clothes_category' => $clothesCategoryKey
                        ]);
                    }
                }
            }
        }
    }
}
