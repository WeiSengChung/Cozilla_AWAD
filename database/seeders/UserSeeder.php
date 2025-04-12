<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        User::create(['email' => "xuanying@admin.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_ADMIN]);
        User::create(['email' => "aiksuan@admin.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_ADMIN]);
        User::create(['email' => "chienhow@admin.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_ADMIN]);
        User::create(['email' => "weiseng@admin.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_ADMIN]);

        //users
        User::create(['email' => "xuanying@gmail.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_USER]);
        User::create(['email' => "aiksuan@gmail.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_USER]);
        User::create(['email' => "chienhow@gmail.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_USER]);
        User::create(['email' => "weiseng@gmail.com", 'password' => Hash::make('12345678'), 'role' => User::ROLE_USER]);
    }
}
