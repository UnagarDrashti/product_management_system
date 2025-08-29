<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        return view('customer.cart.index', ['cart' => $cart]);
    }

    public function add(Product $product)
    {
        
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
        $item = $cart->items()->where('product_id', $product->id)->first();
        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        return response()->json(['success' => true, 'cart_count' => $cart->items()->count()]);
    }

    public function update(Request $request, Product $product)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) return response()->json(['success' => false]);

        $item = $cart->items()->where('product_id', $product->id)->first();
        if ($item) {
            $item->quantity = $request->quantity;
            $item->save();
        } else {
            return response()->json(['success' => false]);
        }

        $item_total = $item->price * $item->quantity;
        $cart_total = $cart->items()->sum(function($i) {
            return $i->price * $i->quantity;
        });

        return response()->json([
            'success' => true,
            'item_total' => $item_total,
            'cart_total' => $cart_total
        ]);
    }

    public function remove(Product $product)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->where('product_id', $product->id)->delete();
        }

        return response()->json(['success' => true]);
    }
}
