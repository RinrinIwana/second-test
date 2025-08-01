<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonsTableSeeder extends Seeder
{
    public function run(): void
    {
        $seasons = ['春', '夏', '秋', '冬'];

        foreach ($seasons as $season) {
            Season::firstOrCreate(['name' => $season]);
        }
    }
}