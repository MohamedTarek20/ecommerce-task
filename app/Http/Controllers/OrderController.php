<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(StoreRequest $request)
    {

        $order = Order::create();

        $productsToAttach = [];

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);

            $product->stock -= $productData['quantity'];
            $product->save();

            $productsToAttach[] = [
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
            ];
        }

        $order->products()->attach($productsToAttach);

        event(new OrderPlaced($order));

        return response()->json($order->load('products'), 201);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order->load('products'), 200);
    }
}
