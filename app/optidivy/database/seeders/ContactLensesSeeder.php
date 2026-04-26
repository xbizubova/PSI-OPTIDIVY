<?php

namespace Database\Seeders;

use App\Models\ContactLenses;
use Illuminate\Database\Seeder;

class ContactLensesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['wear_period' => 'daily'],
            ['wear_period' => 'weekly'],
            ['wear_period' => 'monthly'],
            ['wear_period' => 'yearly'],
        ];

        foreach ($types as $type) {
            ContactLenses::create($type);
        }
    }
}
