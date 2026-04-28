<div id="cartDrawer" class="cart-sidebar">
    <div class="cart-header">
        <h3 class="text-xl font-black text-navy-dark uppercase italic">Troli Saya</h3>
        <button onclick="toggleCart()" class="text-gray-400 hover:text-red-500 transition">
            <i data-lucide="x"></i>
        </button>
    </div>

    <div class="cart-items-list">
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

                    <div class="cart-item">
                        <img src="{{ asset('uploads/products/'.$item->product->image) }}" 
                             class="w-16 h-16 rounded-2xl object-cover">

                        <div class="flex-1">
                            <h4 class="font-bold text-navy-dark text-sm">
                                {{ $item->product->name }}
                            </h4>

                            <p class="text-orange-brand font-black text-xs">
                                Rp {{ number_format($subtotal,0,',','.') }}
                            </p>

                            <div class="flex items-center gap-3 mt-2">
                                <!-- UPDATE QTY -->
                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button name="action" value="minus" class="qty-btn">-</button>
                                    <span class="font-bold text-xs">{{ $item->quantity }}</span>
                                    <button name="action" value="plus" class="qty-btn">+</button>
                                </form>

                                <!-- DELETE -->
                                <form action="{{ route('cart.destroy', $item) }}" method="POST" class="ml-auto">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-400 hover:text-red-600">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            @empty
                <p class="text-center text-gray-400 mt-20 italic">
                    Troli masih kosong...
                </p>
            @endforelse
        @endauth
    </div>

    @auth
        @if(isset($total) && $total > 0)
        <div class="cart-footer">
            <div class="flex justify-between items-center mb-6 p-4 bg-gray-50 rounded-lg">
                <span class="font-bold text-gray-600 text-sm">TOTAL BELANJA</span>
                <span class="font-black text-orange-brand text-2xl">
                    Rp {{ number_format($total,0,',','.') }}
                </span>
            </div>

            <form action="{{ route('cart.checkout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit"
    class="w-full py-3 px-4 bg-orange-500 text-white font-black text-base uppercase tracking-wide rounded-xl 
    transition-all duration-300 hover:bg-orange-600 active:scale-95 shadow-lg hover:shadow-xl 
    flex items-center justify-center gap-2">

    <i data-lucide="shopping-cart" class="w-5 h-5 text-white"></i>
    <span class="text-white">CHECKOUT KE WHATSAPP</span>
</button>
            </form>
        </div>
        @endif
    @endauth
</div>

<div id="cartOverlay" class="cart-overlay" onclick="toggleCart()"></div>