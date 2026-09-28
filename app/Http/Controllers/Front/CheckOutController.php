<?php

namespace App\Http\Controllers\Front;

use App\Events\EmptyCart;
use App\Events\OrderCreated;
use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view("front.checkout", ['cart' => $cart]);
    }
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'addr.billing.first_name' => 'required|string|max:255',
            'addr.billing.last_name' => 'required|string|max:255',
            'addr.billing.email' => 'required|email|max:255',
            'addr.billing.phone_number' => 'required|string|max:255',
            'addr.billing.street_address' => 'required|string|max:255',
            'addr.billing.city' => 'required|string|max:255',
        ]);

        $items  = $cart->get()->groupBy('product.store_id')->all();
        if (empty($items)) {
            return redirect()->route('home');
        }

        DB::beginTransaction();
        try {
            $addresses = $request->post('addr', []);
            if (empty($addresses['shipping']['first_name'])) {
                $addresses['shipping'] = $addresses['billing'] ?? [];
            }

            foreach ($items as $store_id => $cartItems) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'pending',
                    'payment_status' => 'pending',
                ]);
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                    ]);
                }
                foreach ($addresses as $type => $address) {
                    $address['type'] = $type;
                    $addressData = \Illuminate\Support\Arr::only($address, [
                        'first_name',
                        'last_name',
                        'email',
                        'phone_number',
                        'street_address',
                        'city',
                        'postal_code',
                        'state',
                        'type'
                    ]);
                    $order->addresses()->create($addressData);
                }
            }
            OrderPlaced::dispatch($order);
            EmptyCart::dispatch($cart);
            OrderCreated::dispatch($order);
            DB::commit();
            return redirect()->route('home');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([
                'message' => $e->getMessage(),
            ]);
        }
    }
}