<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admins
        User::create(['email' => "xuanying@admin.com", 'password' => "xuanying123", 'role' => User::ROLE_ADMIN]);
        User::create(['email' => "aiksuan@admin.com", 'password' => "aiksuan123", 'role' => User::ROLE_ADMIN]);
        User::create(['email' => "chienhow@admin.com", 'password' => "chienhow123", 'role' => User::ROLE_ADMIN]);
        User::create(['email' => "weiseng@admin.com", 'password' => "weiseng123", 'role' => User::ROLE_ADMIN]);

        //users
        User::create(['email' => "xuanying@gmail.com", 'password' => "xuanying123", 'role' => User::ROLE_USER]);
        User::create(['email' => "aiksuan@gmail.com", 'password' => "aiksuan123", 'role' => User::ROLE_USER]);
        User::create(['email' => "chienhow@gmail.com", 'password' => "chienhow123", 'role' => User::ROLE_USER]);
        User::create(['email' => "weiseng@gmail.com", 'password' => "weiseng123", 'role' => User::ROLE_USER]);
    }
}
