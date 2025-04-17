<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //xy
        Address::create(['user_id' => 5, 'street' => 'No 20, Jalan Taming Indah 2/2', 'city' => 'Sungai Long, Kajang', 'state' => 'Selangor', 'postcode' => '43000']);

        //as
        Address::create(['user_id' => 6, 'street' => '3A Green View Residence', 'city' => 'Sungai Long, Kajang', 'state' => 'Selangor', 'postcode' => '43000']);

        //ch
        Address::create(['user_id' => 7, 'street' => 'Scotpine Condominium', 'city' => 'Sungai Long, Kajang', 'state' => 'Selangor', 'postcode' => '43000']);

        //ws
        Address::create(['user_id' => 8, 'street' => 'Jalan SL2/3', 'city' => 'Sungai Long, Kajang', 'state' => 'Selangor', 'postcode' => '43000']);
    }
}
