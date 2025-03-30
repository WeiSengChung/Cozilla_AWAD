<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserProfile::truncate();
        $users = User::all();

        foreach ($users as $user) {
            $firstName = "";
            $lastName = "";
            $phone = "";
            $email = $user->email;
            if (Str::startsWith($email, "x")) {
                $firstName = "XuanYing";
                $lastName = "Chia";
                $phone = "0123456789";
            } elseif (Str::startsWith($email, "a")) {
                $firstName = "Aik Suan";
                $lastName = "Tan";
                $phone = "0123456789";
            } elseif (Str::startsWith($email, "c")) {
                $firstName = "Chien How";
                $lastName = "Ooi";
                $phone = "0123456789";
            } elseif (Str::startsWith($email, "w")) {
                $firstName = "Wei Seng";
                $lastName = "Chung";
                $phone = "0123456789";
            }
            UserProfile::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone
            ]);
        }
    }
}
