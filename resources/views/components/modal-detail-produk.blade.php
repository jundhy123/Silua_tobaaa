<!-- ==========================================================================
     MODAL DETAIL & REVIEW CRUD
     ========================================================================== -->
<div id="modalOrder" class="product-modal">
    <div class="modal-content shadow-2xl">
        <button onclick="closeModal()" class="modal-close-btn"><i data-lucide="x"></i></button>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- SISI KIRI: GAMBAR FOKUS -->
            <div class="relative overflow-hidden rounded-[3rem] shadow-xl border-[8px] border-gray-50">
                <img id="m-img" src="" class="w-full h-[450px] object-cover">
            </div>

            <!-- SISI KANAN: FORM & DETAIL -->
            <div class="flex flex-col justify-center">
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="m-id">
                    <h2 id="m-name" class="text-4xl font-black text-navy-dark italic mb-1" style="font-family: 'Lora', serif;"></h2>
                    <p class="text-xs text-orange-brand font-bold mb-6" id="m-review-count-label">(0 Ulasan)</p>

                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 mb-6">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Harga Satuan</span>
                        <h3 id="m-price" class="text-3xl font-black text-navy-dark"></h3>
                    </div>
                    
                    <p id="m-desc" class="text-gray-500 mb-8 leading-relaxed text-sm"></p>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center bg-gray-100 rounded-2xl px-5 py-3 gap-6">
                            <button type="button" onclick="changeQty(-1)" class="font-black text-navy-dark hover:text-orange-brand text-xl">-</button>
                            <input type="number" name="quantity" id="m-qty" value="1" min="1" class="bg-transparent border-none w-10 text-center font-black text-navy-dark outline-none">
                            <button type="button" onclick="changeQty(1)" class="font-black text-navy-dark hover:text-orange-brand text-xl">+</button>
                        </div>
                        <button type="submit" class="flex-1 btn-masuk-troli">
                            <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i> MASUKKAN KE TROLI
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- AREA ULASAN -->
        <div class="mt-20 border-t border-gray-100 pt-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
                <h4 class="text-2xl font-black text-navy-dark uppercase tracking-widest">Ulasan Produk</h4>
                @auth
                <button onclick="toggleReviewForm()" class="btn-tambah-ulasan" id="btn-tulis-ulasan">
                    <i data-lucide="edit-3" class="w-4 h-4"></i> <span>Tulis Ulasan</span>
                </button>
                @endauth
            </div>

            <!-- FORM TAMBAH/EDIT ULASAN -->
            @auth
            <div id="reviewFormSection" class="hidden mb-16 max-w-2xl mx-auto bg-gray-50 p-8 rounded-[3rem] border-2 border-dashed border-gray-200">
                <form action="{{ route('review.store') }}" method="POST" id="mainReviewForm">
                    @csrf
                    <input type="hidden" name="product_id" id="rev-prod-id">
                    
                    <div class="mb-6 text-center">
                        <label class="block text-xs font-black text-navy-dark uppercase mb-3 tracking-widest">Rating Anda</label>
                        <div class="flex justify-center gap-2" id="star-input">
                            @for($i=1; $i<=5; $i++)
                                <i data-lucide="star" class="w-8 h-8 cursor-pointer star-btn text-gray-300" onclick="setRating({{ $i }})" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="selected-rating" value="5" required>
                    </div>

                    <div class="mb-6">
                        <textarea name="comment" id="rev-comment" rows="3" class="silua-input !py-4" placeholder="Bagikan pendapat Anda..." required></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-admin-submit-v2 flex-1 shadow-lg" id="submit-review-text">KIRIM ULASAN</button>
                        <button type="button" onclick="toggleReviewForm()" class="px-6 text-gray-400 font-bold uppercase text-[10px]">Batal</button>
                    </div>
                </form>
            </div>
            @endauth
            
            <div id="m-reviews-container" class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                <!-- JavaScript Fill -->
            </div>
        </div>
    </div>
</div>