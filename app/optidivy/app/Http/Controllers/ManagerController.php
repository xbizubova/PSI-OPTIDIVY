<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query()
            ->with(['frame', 'lense', 'contactLense'])
            ->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->whereIn('product_type', (array) $request->type);
        }

        if ($request->filled('stock')) {
            $query->where(function ($stocks) use ($request) {
                foreach ((array) $request->stock as $stockState) {
                    if ($stockState === 'low') {
                        $stocks->orWhereColumn('quantity', '<=', 'min_quantity');
                    }

                    if ($stockState === 'available') {
                        $stocks->orWhereColumn('quantity', '>', 'min_quantity');
                    }

                    if ($stockState === 'discontinued') {
                        $stocks->orWhere('discontinued', true);
                    }
                }
            });
        }

        if ($request->filled('price')) {
            $query->where(function ($prices) use ($request) {
                foreach ((array) $request->price as $price) {
                    if ($price === 'under_30') {
                        $prices->orWhere('price', '<', 30);
                    }

                    if ($price === '30_50') {
                        $prices->orWhereBetween('price', [30, 50]);
                    }

                    if ($price === 'over_50') {
                        $prices->orWhere('price', '>', 50);
                    }

                    if ($price === 'discounted') {
                        $prices->orWhere('discount', '>', 0);
                    }
                }
            });
        }

        $stocks = $query->paginate(8)->withQueryString();

        return view('manager', compact('stocks'));
    }
}
