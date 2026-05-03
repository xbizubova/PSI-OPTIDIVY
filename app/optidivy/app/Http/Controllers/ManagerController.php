<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    if ($stockState === Stock::STATE_OK || $stockState === 'available') {
                        $stocks->orWhereColumn('quantity', '>', 'min_quantity');
                    }

                    if ($stockState === 'low') {
                        $stocks->orWhere(function ($low) {
                            $low->whereColumn('quantity', '<=', 'min_quantity')
                                ->whereRaw('quantity > min_quantity / 2');
                        });
                    }

                    if ($stockState === Stock::STATE_CRITICAL) {
                        $stocks->orWhereRaw('quantity <= min_quantity / 2');
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

        $scan = [
            Stock::STATE_OK => Stock::whereColumn('quantity', '>', 'min_quantity')->count(),
            Stock::STATE_LOW => Stock::whereColumn('quantity', '<=', 'min_quantity')
                ->whereRaw('quantity > min_quantity / 2')
                ->count(),
            Stock::STATE_CRITICAL => Stock::whereRaw('quantity <= min_quantity / 2')->count(),
        ];

        $stocks = $query->paginate(8)->withQueryString();

        return view('manager', compact('stocks', 'scan'));
    }

    public function orderFromSupplier(Stock $stock)
    {
        $quantity = $stock->mockReorderQuantity();

        DB::transaction(function () use ($stock, $quantity) {
            $stock->increment('quantity', $quantity);
        });

        return back()->with(
            'success',
            "Mock objednávka od dodávateľa prijatá: {$stock->name} +{$quantity} ks."
        );
    }
}
