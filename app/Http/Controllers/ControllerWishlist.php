<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class ControllerWishlist extends Controller
{
    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        return view('wishlist',compact('items'));
    }

    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price, [
            'image' => $request->image // Store image in the options array
        ])->associate('App\Models\Product');
        return redirect()->back();

    }

    public function wishlist_item_remove($rowid)
    {
        $cart_item = Cart:: instance('wishlist')->remove($rowid);
        return redirect()->back();
    }

    public function wishlist_empty()
    {
        $cart_item = Cart:: instance('wishlist')->destroy();
        return redirect()->back();
    }

    public function wishlist_to_cart($rowid)
    {
        $item = Cart:: instance('wishlist')->get($rowid);
        Cart:: instance('wishlist')->remove($rowid);
        Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price, [
            'image' => $item->image // Store image in the options array
        ])->associate('App\Models\Product');
        return redirect()->back();

    }
}
