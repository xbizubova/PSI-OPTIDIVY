<?php

namespace Database\Seeders;

use App\Models\ContactLenses;
use App\Models\Frame;
use App\Models\Lense;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $frames = [
            ['name' => 'Klasik Cierne', 'description' => 'Klasicky cierny ram', 'price' => 29.99, 'discount' => 0, 'quantity' => 15, 'min_quantity' => 3, 'color' => 'black', 'material' => 'acetate'],
            ['name' => 'Zlaty Elegan', 'description' => 'Elegantny zlaty ram', 'price' => 49.99, 'discount' => 15, 'quantity' => 1, 'min_quantity' => 4, 'color' => 'gold', 'material' => 'metal'],
            ['name' => 'Hnedy Klasik', 'description' => 'Hnedy acetatovy ram', 'price' => 34.99, 'discount' => 0, 'quantity' => 2, 'min_quantity' => 4, 'color' => 'brown', 'material' => 'acetate'],
        ];

        foreach ($frames as $data) {
            $stock = Stock::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'],
                'quantity' => $data['quantity'],
                'min_quantity' => $data['min_quantity'],
                'product_type' => 'frame',
            ]);

            Frame::create([
                'stock_id' => $stock->id,
                'color' => $data['color'],
                'material' => $data['material'],
            ]);
        }

        $lenses = [
            ['name' => 'Standardne sosovky', 'description' => 'Bez filtra', 'price' => 19.99, 'discount' => 0, 'quantity' => 30, 'min_quantity' => 5, 'filter' => 'none'],
            ['name' => 'Blue Light sosovky', 'description' => 'Filter modreho svetla', 'price' => 34.99, 'discount' => 10, 'quantity' => 4, 'min_quantity' => 6, 'filter' => 'blue_light'],
            ['name' => 'Fotochromaticke sosovky', 'description' => 'Fotochromaticke', 'price' => 49.99, 'discount' => 0, 'quantity' => 0, 'min_quantity' => 4, 'filter' => 'photochromic'],
            ['name' => 'Polarizovane sosovky', 'description' => 'Polarizovane', 'price' => 44.99, 'discount' => 5, 'quantity' => 2, 'min_quantity' => 5, 'filter' => 'polarized'],
        ];

        foreach ($lenses as $data) {
            $stock = Stock::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'],
                'quantity' => $data['quantity'],
                'min_quantity' => $data['min_quantity'],
                'product_type' => 'lense',
            ]);

            Lense::create([
                'stock_id' => $stock->id,
                'filter' => $data['filter'],
            ]);
        }

        $contactLenses = [
            ['name' => 'DailyFresh', 'description' => 'Jednodenne', 'price' => 29.99, 'discount' => 0, 'quantity' => 8, 'min_quantity' => 10, 'wear_period' => 'daily'],
            ['name' => 'WeeklyComfort', 'description' => 'Tyzdenne', 'price' => 39.99, 'discount' => 5, 'quantity' => 30, 'min_quantity' => 5, 'wear_period' => 'weekly'],
            ['name' => 'MonthlyPro', 'description' => 'Mesacne', 'price' => 49.99, 'discount' => 0, 'quantity' => 1, 'min_quantity' => 4, 'wear_period' => 'monthly'],
            ['name' => 'YearlyMax', 'description' => 'Rocne', 'price' => 69.99, 'discount' => 0, 'quantity' => 10, 'min_quantity' => 2, 'wear_period' => 'yearly'],
        ];

        foreach ($contactLenses as $data) {
            $stock = Stock::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'],
                'quantity' => $data['quantity'],
                'min_quantity' => $data['min_quantity'],
                'product_type' => 'contact_lense',
            ]);

            ContactLenses::create([
                'stock_id' => $stock->id,
                'wear_period' => $data['wear_period'],
            ]);
        }
    }
}
