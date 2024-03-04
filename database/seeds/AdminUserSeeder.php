<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([

            'name' => 'Admin',

            'email' => 'admin@gmail.com',

            'password' => Hash::make('Admin@0987'),

        ]);
    }
}
