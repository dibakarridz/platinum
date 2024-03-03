<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
        $user = [
            'type' => 1,
            'name' => 'Jhon Doe',
            'username' => 'admin',
            'email' => 'admin@domain.com',
            'status' => 1,
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),

        ];
        User::factory()->create($user);
    }
}
