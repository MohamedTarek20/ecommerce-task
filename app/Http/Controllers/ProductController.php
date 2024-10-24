<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Cache::remember('products', 60, function () use ($request) {
            $query = Product::query();
            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->input('min_price'));
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->input('max_price'));
            }
            return $query->paginate(10);
        });

        return response()->json($products, 200);
    }
}
