<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        Setting::create([
            'name' => 'Staff Club',
            'address' => 'University Of Nigeria Nsukka',
            'email' => 'email@inventory-manager.com',
            'phone' => '0213546566',
            'mobile' => '6546564656',
            'logo' => 'logo.png',
            'city' => 'Nsukka',
            'country' => 'Nigeria',
            'zip_code' => '410004'
        ]);
    }
}
