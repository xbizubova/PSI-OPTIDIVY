<?php

namespace Database\Seeders;

use App\Models\Lense;
use Illuminate\Database\Seeder;

class LenseSeeder extends Seeder
{
    public function run(): void
    {
        $lenses = [
            ['filter' => 'none'],
            ['filter' => 'blue_light'],
            ['filter' => 'photochromic'],
            ['filter' => 'polarized'],
        ];

        foreach ($lenses as $lense) {
            Lense::create($lense);
        }
    }
}
