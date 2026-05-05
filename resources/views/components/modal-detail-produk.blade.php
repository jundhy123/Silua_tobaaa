<!-- ========================================================================== 
     MODAL DETAIL & REVIEW CRUD (FIXED & COMPLETE)
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
            <div class="flex flex-col justify-center text-left">
                <form id="formOrder" action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="m-id">

                    <h2 id="m-name" class="text-4xl font-black text-navy-dark italic mb-1" style="font-family: 'Playfair Display', serif;"></h2>
                    <p class="text-[10px] text-orange-brand font-bold mb-6 tracking-widest uppercase" id="m-review-count-label">(0 ULASAN)</p>

                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 mb-6">
                        <span class="text-[10px] font-black text-gray-400 uppercase block mb-1">
                            Harga Satuan
                        </span>
                        <h3 id="m-price" class="text-3xl font-black text-navy-dark"></h3>
                    </div>
                    
                    <p id="m-desc" class="text-gray-500 mb-8 text-sm leading-relaxed"></p>

                    <!-- QTY -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center bg-gray-100 rounded-2xl px-5 py-3 gap-6">
                            <button type="button" onclick="changeQty(-1)" class="font-black text-navy-dark text-xl">-</button>
                            <input type="number" name="quantity" id="m-qty" value="1" min="1" readonly
                                class="bg-transparent w-10 text-center font-black text-navy-dark outline-none">
                            <button type="button" onclick="changeQty(1)" class="font-black text-navy-dark text-xl">+</button>
                        </div>
                    </div>

                    <!-- BUTTON AREA -->
                    <div class="flex flex-col gap-3 mt-8">
                        <button type="button" onclick="handleDirectOrder()"
                            class="w-full py-4 px-6 bg-[#25D366] text-white font-black text-sm uppercase rounded-2xl 
                            hover:bg-[#128C7E] active:scale-95 transition flex items-center justify-center gap-3 shadow-lg">
                            <i data-lucide="message-circle" class="w-6 h-6"></i>
                            <span>Pesan Sekarang (WhatsApp)</span>
                        </button>

                        <button type="submit"
                            class="w-full py-4 px-6 bg-[#1a1a3a] text-white font-bold text-sm uppercase rounded-2xl 
                            hover:bg-orange-600 active:scale-95 transition flex items-center justify-center gap-3 shadow">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>Masukkan ke Troli</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- AREA ULASAN -->
        <div class="mt-20 border-t pt-12 text-left">
            <div class="flex justify-between items-center mb-10">
                <h4 class="text-2xl font-black text-navy-dark uppercase tracking-widest">Ulasan Produk</h4>

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
            <div id="reviewFormSection" class="hidden mb-12 bg-[#F9F9F4] p-8 rounded-[3rem] border-2 border-dashed border-gray-200 max-w-2xl mx-auto">
                <form action="{{ route('review.store') }}" method="POST" id="mainReviewForm">
                    @csrf
                    <input type="hidden" name="product_id" id="rev-prod-id">

                    <div class="mb-6 text-center">
                        <label class="block text-[10px] font-black text-navy-dark uppercase mb-3 tracking-widest">Rating Anda</label>
                        <div class="flex justify-center gap-3" id="star-input">
                            @for($i=1; $i<=5; $i++)
                                <i data-lucide="star" class="w-8 h-8 cursor-pointer text-gray-300 star-btn" 
                                   onclick="setRating({{ $i }})" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="selected-rating" value="5">
                    </div>

                    <textarea name="comment" id="rev-comment" rows="3"
                        class="w-full p-5 rounded-2xl border-none bg-white shadow-sm mb-4 outline-none"
                        placeholder="Bagikan kesan Anda tentang hidangan ini..." required></textarea>

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 py-4 bg-[#5B5B41] text-white rounded-2xl font-bold text-xs tracking-widest uppercase hover:bg-black transition shadow-lg">Kirim Ulasan</button>
                        <button type="button" onclick="toggleReviewForm()" class="px-6 text-gray-400 font-bold uppercase text-[10px]">Batal</button>
                    </div>
                </form>
            </div>
            @endauth

            <!-- CONTAINER LIST ULASAN -->
            <div id="m-reviews-container" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- JavaScript akan mengisi data di sini -->
            </div>
        </div>
    </div>
</div>

<!-- Form Tersembunyi untuk Direct Order -->
<form id="directOrderForm" action="{{ route('cart.directOrder') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="product_id" id="do-id">
    <input type="hidden" name="quantity" id="do-qty">
</form>

<!-- ================= JS ================= -->
<script>
// Ambil ID user login (jika ada) untuk filter edit/hapus
const currentUserId = {{ auth()->id() ?? 'null' }};

/**
 * FUNGSI UTAMA UNTUK MEMBUKA MODAL (Dipanggil dari Katalog)
 */
function openOrderModal(id, name, price, img, desc, reviews = []) {
    // 1. Isi Data Dasar Produk
    document.getElementById('m-id').value = id;
    if(document.getElementById('rev-prod-id')) document.getElementById('rev-prod-id').value = id;
    document.getElementById('m-name').innerText = name;
    document.getElementById('m-price').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('m-img').src = img;
    document.getElementById('m-desc').innerText = desc || "Cita rasa autentik nusantara.";
    document.getElementById('m-qty').value = 1;

    // 2. Render Ulasan Pelanggan
    const container = document.getElementById('m-reviews-container');
    const countLabel = document.getElementById('m-review-count-label');
    container.innerHTML = '';
    countLabel.innerText = `(${reviews.length} ULASAN)`;

    if (reviews.length > 0) {
        reviews.forEach(rev => {
            // Generate Bintang
            let starsHTML = '';
            for(let i=1; i<=5; i++) {
                starsHTML += `<i data-lucide="star" class="w-3 h-3 ${i <= rev.rating ? 'text-yellow-500' : 'text-gray-200'}" fill="${i <= rev.rating ? 'currentColor' : 'none'}"></i>`;
            }

            // Cek apakah ulasan ini milik user yang sedang login
            let actions = '';
            if(currentUserId && rev.user_id === currentUserId) {
                actions = `
                    <div class="flex gap-4 mt-4 border-t pt-3">
                        <button type="button" onclick="editReview(${rev.id}, ${rev.rating}, '${rev.comment.replace(/'/g, "\\'")}')" class="text-[9px] font-black text-navy-dark underline uppercase">Edit</button>
                        <form action="/review/${rev.id}" method="POST" onsubmit="return confirm('Hapus ulasan?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[9px] font-black text-red-500 underline uppercase">Hapus</button>
                        </form>
                    </div>`;
            }

            container.innerHTML += `
                <div class="bg-gray-50 p-8 rounded-[2.5rem] border border-gray-100 relative">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-1">${starsHTML}</div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">${new Date(rev.created_at).toLocaleDateString('id-ID')}</span>
                    </div>
                    <p class="font-black text-navy-dark text-sm mb-1">${rev.user ? rev.user.name : 'Pelanggan Silua'}</p>
                    <p class="text-xs text-gray-500 italic leading-relaxed">"${rev.comment}"</p>
                    ${actions}
                </div>`;
        });
    } else {
        container.innerHTML = '<p class="col-span-full text-center text-gray-400 italic py-10">Belum ada ulasan untuk hidangan ini.</p>';
    }

    // 3. Tampilkan Modal
    document.getElementById('modalOrder').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Refresh Ikon Lucide
    setTimeout(() => lucide.createIcons(), 50);
}

function closeModal() {
    document.getElementById('modalOrder').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function changeQty(val) {
    let qtyInput = document.getElementById('m-qty');
    let current = parseInt(qtyInput.value);
    if (current + val >= 1) {
        qtyInput.value = current + val;
    }
}

function handleDirectOrder() {
    document.getElementById('do-id').value = document.getElementById('m-id').value;
    document.getElementById('do-qty').value = document.getElementById('m-qty').value;
    document.getElementById('directOrderForm').submit();
}

function toggleReviewForm() {
    const section = document.getElementById('reviewFormSection');
    section.classList.toggle('hidden');
}

function editReview(id, rating, comment) {
    toggleReviewForm();
    document.getElementById('rev-prod-id').value = document.getElementById('m-id').value;
    document.getElementById('selected-rating').value = rating;
    document.getElementById('rev-comment').value = comment;
    setRating(rating);
}

function setRating(n) {
    document.getElementById('selected-rating').value = n;
    const stars = document.querySelectorAll('#star-input .star-btn');
    stars.forEach((s, i) => {
        if(i < n) {
            s.classList.add('text-yellow-500');
            s.setAttribute('fill', 'currentColor');
        } else {
            s.classList.remove('text-yellow-500');
            s.setAttribute('fill', 'none');
        }
    });
}
</script>