<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;
use App\Models\Frame;
use App\Models\Lense;
use App\Models\ContactLenses;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $frames = [
            ['name' => 'Klasik Čierne', 'description' => 'Klasický čierny rám', 'price' => 29.99, 'discount' => 0,  'quantity' => 15, 'min_quantity' => 3, 'color' => 'black',  'material' => 'acetate'],
            ['name' => 'Zlatý Elegán',  'description' => 'Elegantný zlatý rám',  'price' => 49.99, 'discount' => 15, 'quantity' => 4,  'min_quantity' => 1, 'color' => 'gold',   'material' => 'metal'],
            ['name' => 'Hnedý Klasik',  'description' => 'Hnedý acetátový rám',  'price' => 34.99, 'discount' => 0,  'quantity' => 8,  'min_quantity' => 2, 'color' => 'brown',  'material' => 'acetate'],
        ];

        foreach ($frames as $data) {
            $stock = Stock::create([
                'name'         => $data['name'],
                'description'  => $data['description'],
                'price'        => $data['price'],
                'discount'     => $data['discount'],
                'quantity'     => $data['quantity'],
                'min_quantity' => $data['min_quantity'],
                'product_type' => 'frame',
            ]);
            Frame::create([
                'stock_id' => $stock->id,
                'color'    => $data['color'],
                'material' => $data['material'],
            ]);
        }

        $lenses = [
            ['name' => 'Štandardné šošovky',     'description' => 'Bez filtra',           'price' => 19.99, 'discount' => 0,  'quantity' => 30, 'min_quantity' => 5, 'filter' => 'none'],
            ['name' => 'Blue Light šošovky',      'description' => 'Filter modrého svetla', 'price' => 34.99, 'discount' => 10, 'quantity' => 20, 'min_quantity' => 4, 'filter' => 'blue_light'],
            ['name' => 'Fotochromatické šošovky', 'description' => 'Fotochromatické',       'price' => 49.99, 'discount' => 0,  'quantity' => 12, 'min_quantity' => 3, 'filter' => 'photochromic'],
            ['name' => 'Polarizované šošovky',    'description' => 'Polarizované',          'price' => 44.99, 'discount' => 5,  'quantity' => 10, 'min_quantity' => 2, 'filter' => 'polarized'],
        ];

        foreach ($lenses as $data) {
            $stock = Stock::create([
                'name'         => $data['name'],
                'description'  => $data['description'],
                'price'        => $data['price'],
                'discount'     => $data['discount'],
                'quantity'     => $data['quantity'],
                'min_quantity' => $data['min_quantity'],
                'product_type' => 'lense',
            ]);
            Lense::create([
                'stock_id' => $stock->id,
                'filter'   => $data['filter'],
            ]);
        }

        $contactLenses = [
            ['name' => 'DailyFresh',    'description' => 'Jednodenné', 'price' => 29.99, 'discount' => 0, 'quantity' => 50, 'min_quantity' => 10, 'wear_period' => 'daily'],
            ['name' => 'WeeklyComfort', 'description' => 'Týždenné',   'price' => 39.99, 'discount' => 5, 'quantity' => 30, 'min_quantity' => 5,  'wear_period' => 'weekly'],
            ['name' => 'MonthlyPro',    'description' => 'Mesačné',    'price' => 49.99, 'discount' => 0, 'quantity' => 20, 'min_quantity' => 4,  'wear_period' => 'monthly'],
            ['name' => 'YearlyMax',     'description' => 'Ročné',      'price' => 69.99, 'discount' => 0, 'quantity' => 10, 'min_quantity' => 2,  'wear_period' => 'yearly'],
        ];

        foreach ($contactLenses as $data) {
            $stock = Stock::create([
                'name'         => $data['name'],
                'description'  => $data['description'],
                'price'        => $data['price'],
                'discount'     => $data['discount'],
                'quantity'     => $data['quantity'],
                'min_quantity' => $data['min_quantity'],
                'product_type' => 'contact_lense',
            ]);
            ContactLenses::create([
                'stock_id'    => $stock->id,
                'wear_period' => $data['wear_period'],
            ]);
        }
    }
}
