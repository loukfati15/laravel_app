<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['region_name' => 'Tanger_Tetouan_Hoceima', 'region_number' => 1,'country' => 'Morocco'],
            ['region_name' => 'Oriental', 'region_number' => 2,'country'=>'Morocco'],
            ['region_name' => 'Fes_Meknes', 'region_number' => 3,'country'=>'Morocco'],
            ['region_name' => 'Rabat_Sale_Kenitra', 'region_number' => 4,'country' => 'Morocco'],
            ['region_name' => 'Beni_Mellal_Khenifra', 'region_number' => 5,'country' => 'Morocco'],
            ['region_name' => 'Casablanca_Settat', 'region_number' => 6,'country' => 'Morocco'],
            ['region_name' => 'Marrakech_Safi', 'region_number' => 7,'country' => 'Morocco'],
            ['region_name' => 'Draa_Tafilalet', 'region_number' => 8,'country' => 'Morocco'],
            ['region_name' => 'Souss_Massa', 'region_number' => 9,'country' => 'Morocco'],
            ['region_name' => 'Guelmim_Oued Noun', 'region_number' => 10,'country' => 'Morocco'],
            ['region_name' => 'Laâyoune_Saguia_Hamra', 'region_number' => 11,'country' => 'Morocco'],
            ['region_name' => 'Dakhla_Oued_Dahab', 'region_number' => 12,'country' => 'Morocco'],
        ];

        DB::table('regions')->insert($regions);
    }
}

