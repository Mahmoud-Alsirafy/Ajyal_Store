<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{ $items->count() }}</span>
    </a>

    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $items->count() }}Items</span>
            <a href="{{ route('cart.index') }}">View Cart</a>
        </div>
        <ul class="shopping-list">
            @foreach ($items as $item)
                <li>
                    <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                            class="lni lni-close"></i></a>
                    <div class="cart-img-head">
                        <a class="cart-img" href="{{ route('products.show', $item->product->slug) }}"><img
                                src="{{ $item->product->category->logo_image }}" alt="#" /></a>
                    </div>
                    <div class="content">
                        <h4>
                            <a href="product-details.html">
                                {{ $item->name }}</a>
                        </h4>
                        <p class="quantity">
                            {{ $item->quantity }} <span
                                class="amount">{{ App\Helpers\Currency::format($item->price) }}</span>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">{{ App\Helpers\Currency::format($total) }}</span>
            </div>
            <div class="button">
                <a href="{{ route('checkout') }}" class="btn animate">Checkout</a>
            </div>
        </div>
    </div>
</div>
