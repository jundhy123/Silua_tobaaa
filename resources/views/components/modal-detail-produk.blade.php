<!-- ========================================================================== 
     MODAL DETAIL & REVIEW CRUD (FIXED + RAPIIKAN BUTTON)
     ========================================================================== -->
<div id="modalOrder" class="product-modal">
    <div class="modal-content shadow-2xl">
        <button onclick="closeModal()" class="modal-close-btn">
            <i data-lucide="x"></i>
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- GAMBAR -->
            <div class="relative overflow-hidden rounded-[3rem] shadow-xl border-[8px] border-gray-50">
                <img id="m-img" src="" class="w-full h-[450px] object-cover">
            </div>

            <!-- DETAIL -->
            <div class="flex flex-col justify-center">
                <form id="formOrder" action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="m-id">

                    <h2 id="m-name" class="text-4xl font-black text-navy-dark italic mb-1"></h2>

                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 mb-6">
                        <span class="text-[10px] font-black text-gray-400 uppercase block mb-1">
                            Harga Satuan
                        </span>
                        <h3 id="m-price" class="text-3xl font-black text-navy-dark"></h3>
                    </div>
                    
                    <p id="m-desc" class="text-gray-500 mb-8 text-sm"></p>

                    <!-- QTY -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center bg-gray-100 rounded-2xl px-5 py-3 gap-6">
                            <button type="button" onclick="changeQty(-1)" class="font-black text-navy-dark text-xl">-</button>
                            <input type="number" name="quantity" id="m-qty" value="1" min="1"
                                class="bg-transparent w-10 text-center font-black text-navy-dark outline-none">
                            <button type="button" onclick="changeQty(1)" class="font-black text-navy-dark text-xl">+</button>
                        </div>
                    </div>

                    <!-- BUTTON AREA -->
                    <div class="flex gap-3 mt-6">

                        <!-- MASUKKAN KE TROLI -->
                        <button type="submit"
                            class="flex-1 py-3 px-6 bg-orange-500 text-white font-bold text-sm uppercase rounded-xl 
                            hover:bg-orange-600 active:scale-95 transition flex items-center justify-center gap-2 shadow">
                            
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>Masukkan ke Troli</span>
                        </button>

                        <!-- PESAN SEKARANG -->
                        <button type="button" onclick="pesanSekarang()"
                            class="flex-1 py-3 px-6 bg-green-500 text-white font-bold text-sm uppercase rounded-xl 
                            hover:bg-green-600 active:scale-95 transition flex items-center justify-center gap-2 shadow">
                            
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            <span>Pesan Sekarang</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>

        <!-- ULASAN -->
        <div class="mt-20 border-t pt-12">
            <div class="flex justify-between mb-10">
                <h4 class="text-2xl font-black text-navy-dark">Ulasan Produk</h4>

                @auth
                <button onclick="toggleReviewForm()"
                    class="py-3 px-6 bg-orange-500 text-white font-bold text-sm rounded-xl 
                    hover:bg-orange-600 transition flex items-center gap-2">
                    
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                    Tulis Ulasan
                </button>
                @endauth
            </div>

            @auth
            <div id="reviewFormSection" class="hidden mb-12 bg-orange-50 p-6 rounded-2xl border">
                <form action="{{ route('review.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="rev-prod-id">

                    <div class="mb-6 text-center">
                        <div class="flex justify-center gap-3">
                            @for($i=1; $i<=5; $i++)
                                <i data-lucide="star" 
                                   class="w-8 h-8 cursor-pointer text-gray-300"
                                   onclick="setRating({{ $i }})"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="selected-rating" value="5">
                    </div>

                    <textarea name="comment" rows="3"
                        class="w-full p-3 border rounded-xl mb-4"
                        placeholder="Tulis ulasan..." required></textarea>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 py-2 bg-orange-500 text-white rounded-xl hover:bg-orange-600">
                            Kirim
                        </button>

                        <button type="button" onclick="toggleReviewForm()"
                            class="py-2 px-4 bg-gray-200 rounded-xl">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
            @endauth

            <div id="m-reviews-container"></div>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
function pesanSekarang() {
    let nama = document.getElementById('m-name').innerText;
    let qty = document.getElementById('m-qty').value;
    let harga = document.getElementById('m-price').innerText;

    let pesan = `Halo Admin, saya ingin memesan:\n\nProduk: ${nama}\nJumlah: ${qty}\nHarga: ${harga}`;

    let noWa = "6281234567890"; // GANTI NOMOR ADMIN
    let url = `https://wa.me/${noWa}?text=${encodeURIComponent(pesan)}`;

    window.open(url, '_blank');

    // OPTIONAL: kirim juga ke backend (auto submit)
    document.getElementById('formOrder').submit();
}
</script>