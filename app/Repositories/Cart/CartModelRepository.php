<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }
    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items =  Cart::with('product')->get();
        }
        return $this->items;
    }
    public function add(Product $product, int $quantity)
    {
        $item = Cart::where('product_id', $product->id)->first();
        if (!$item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $this->get()->push($cart);
            return $cart;
        }
        return $item->increment('quantity', $quantity);
    }
    public function update($id, int $quantity)
    {
        Cart::where('id', $id)->update([
            'quantity' => $quantity,
        ]);
    }
    public function delete($id)
    {
        Cart::where('id', $id)->delete();
    }
    public function empty()
    {
        // !!query() because we need to get the cookie_id from the Cart model
        // !!this gloabl scope will not work here
        Cart::query()->delete();
    }
    public function total()
    {
        // return Cart::join('products', 'products.id', '=', 'carts.product_id')
        //     ->selectRaw('SUM(products.price * carts.quantity)as total')
        //     ->value('total');
        return $this->get()->sum(
            fn($item) =>
            $item->quantity * $item->product->price
        );
    }
}