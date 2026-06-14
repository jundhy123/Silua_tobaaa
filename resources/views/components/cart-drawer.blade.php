<div id="cartDrawer" class="cart-sidebar">
    <div class="cart-header">
        <div class="flex flex-col">
            <h3 class="text-xl font-black text-navy-dark uppercase italic" style="font-family: 'Playfair Display', serif;">Troli Saya</h3>
            <span class="text-[9px] font-bold text-orange-brand tracking-widest uppercase">Silua Toba Artisanal</span>
        </div>
        <button onclick="toggleCart()" class="close-cart-btn">
            <i data-lucide="x"></i>
        </button>
    </div>

    <div class="cart-items-list" id="cartItemsContainer">
        @auth
            @php
                $carts = \App\Models\Cart::where('user_id', auth()->id())
                            ->with('product')
                            ->get();
                $total = 0;
            @endphp

            @forelse($carts as $item)
                @if($item->product)
                    @php
                        $subtotal = $item->product->price * $item->quantity;
                        $total += $subtotal;
                    @endphp

                    <div class="cart-item-premium" data-id="{{ $item->id }}">
                        <div class="item-img">
                            <img src="{{ asset('uploads/products/'.$item->product->image) }}" class="w-full h-full object-cover">
                        </div>

                        <div class="item-info">
                            <h4 class="product-name-mini">{{ $item->product->name }}</h4>
                            <p class="product-price-mini">Rp {{ number_format($item->product->price,0,',','.') }}</p>

                            <div class="item-actions-row">
                                <div class="qty-stepper-mini">
                                    <button onclick="updateCartQty({{ $item->id }}, 'minus')" class="step-btn">-</button>
                                    <span class="qty-val">{{ $item->quantity }}</span>
                                    <button onclick="updateCartQty({{ $item->id }}, 'plus')" class="step-btn">+</button>
                                </div>

                                <form action="{{ route('cart.destroy', $item) }}" method="POST" onsubmit="return confirmDelete(this, 'Hapus dari Keranjang?', 'Produk ini akan dihapus dari keranjang belanja Anda.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-icon-btn">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="empty-cart-state">
                    <i data-lucide="shopping-bag" class="w-12 h-12 opacity-10 mx-auto mb-4 text-gray-400"></i>
                    <p class="italic text-gray-400">Troli Anda masih kosong...</p>
                </div>
            @endforelse
        @endauth
    </div>

    @auth
        <div class="cart-footer-premium {{ !isset($total) || $total == 0 ? 'hidden' : '' }}" id="cartFooter">
            <div class="total-row">
                <span class="label">TOTAL BELANJA</span>
                <span class="value" id="cartTotalValue">Rp {{ number_format($total ?? 0,0,',','.') }}</span>
            </div>

            <form action="{{ route('cart.checkout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="btn-checkout-wa">
                    <i data-lucide="message-circle"></i>
                    <span>CHECKOUT KE WHATSAPP</span>
                </button>
            </form>
        </div>
    @endauth
</div>

<!-- Overlay dengan Efek Blur -->
<div id="cartOverlay" class="cart-overlay-blur" onclick="toggleCart()"></div>

