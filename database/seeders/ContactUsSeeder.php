<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactUs;
class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactUs::create([
            'company_address' => 'No 20, Jalan Sungai Long 2/3, Bandar Sungai Long, 43000, Kajang, Selangor',
            'email' => 'cozillaManagement@cozilla.com.my',
            'contact_number' => '018 2639 362',
        ]);
    }
}
