<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            'title' => 'logo title',
            'email' => 'contact@domain.com',
            'mobile_number' => '0123456789',
            'address' => 'Sepko Township,Durgapur',
            'file_path' => null,
            'copyright' => '2023 Durgapur,WB,inc.All rights reserved',
            'developed_by' => 'Ridz Enterprise',
        ];
        Setting::factory()->create($setting);
    }
}
