<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // Okuliare (glasses)
        $glasses = [
            [
                'name'              => 'Klasik Čierne',
                'description'       => 'obyčajné',
                'price'             => 89.99,
                'discount'          => 0,
                'quantity'          => 15,
                'min_quantity'      => 3,
                'product_type'      => 'glasses',
                'product_id'        => 1,
                'product_type_model'=> 'App\Models\Glasses',
            ],
            [
                'name'              => 'Blue Light Shield',
                'description'       => 'modré svetlo',
                'price'             => 119.99,
                'discount'          => 10,
                'quantity'          => 8,
                'min_quantity'      => 2,
                'product_type'      => 'glasses',
                'product_id'        => 2,
                'product_type_model'=> 'App\Models\Glasses',
            ],
            [
                'name'              => 'Hnedý Elegán',
                'description'       => 'fotochromatické',
                'price'             => 149.99,
                'discount'          => 0,
                'quantity'          => 5,
                'min_quantity'      => 2,
                'product_type'      => 'glasses',
                'product_id'        => 3,
                'product_type_model'=> 'App\Models\Glasses',
            ],
            [
                'name'              => 'Zlatý Rám',
                'description'       => 'obyčajné',
                'price'             => 199.99,
                'discount'          => 15,
                'quantity'          => 4,
                'min_quantity'      => 1,
                'product_type'      => 'glasses',
                'product_id'        => 4,
                'product_type_model'=> 'App\Models\Glasses',
            ],
        ];

        // Kontaktné šošovky (contact_lenses)
        $contactLenses = [
            [
                'name'              => 'DailyFresh',
                'description'       => 'jednodenné',
                'price'             => 29.99,
                'discount'          => 0,
                'quantity'          => 50,
                'min_quantity'      => 10,
                'product_type'      => 'contact_lenses',
                'product_id'        => 1,
                'product_type_model'=> 'App\Models\ContactLenses',
            ],
            [
                'name'              => 'WeeklyComfort',
                'description'       => 'týždenné',
                'price'             => 39.99,
                'discount'          => 5,
                'quantity'          => 30,
                'min_quantity'      => 5,
                'product_type'      => 'contact_lenses',
                'product_id'        => 2,
                'product_type_model'=> 'App\Models\ContactLenses',
            ],
            [
                'name'              => 'MonthlyPro',
                'description'       => 'mesačné',
                'price'             => 49.99,
                'discount'          => 0,
                'quantity'          => 20,
                'min_quantity'      => 4,
                'product_type'      => 'contact_lenses',
                'product_id'        => 3,
                'product_type_model'=> 'App\Models\ContactLenses',
            ],
        ];

        foreach (array_merge($glasses, $contactLenses) as $item) {
            Stock::create($item);
        }
    }
}
