<?php

namespace Database\Seeders;

use App\Models\Glasses;
use Illuminate\Database\Seeder;

class GlassesSeeder extends Seeder
{
    public function run(): void
    {
        // Kombinuj rámy (1-8) s šošovkami (1-4)
        $combinations = [
            ['frame_id' => 1, 'lense_id' => 1],
            ['frame_id' => 1, 'lense_id' => 2],
            ['frame_id' => 2, 'lense_id' => 1],
            ['frame_id' => 3, 'lense_id' => 3],
            ['frame_id' => 4, 'lense_id' => 1],
            ['frame_id' => 4, 'lense_id' => 4],
            ['frame_id' => 5, 'lense_id' => 2],
            ['frame_id' => 6, 'lense_id' => 1],
        ];

        foreach ($combinations as $combo) {
            Glasses::create($combo);
        }
    }
}
