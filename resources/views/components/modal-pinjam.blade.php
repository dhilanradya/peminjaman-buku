<!-- Modal Pinjam -->
<div x-data="{ open: false, book: null }" id="pinjamModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">
    <div class="bg-gray-800 rounded-3xl max-w-4xl w-full mx-4 overflow-hidden">
        <div class="flex">
            <!-- Kiri: Detail Buku -->
            <div class="w-5/12 bg-gray-900 p-8">
                <div class="sticky top-8">
                    <img :src="book?.foto ? '/storage/books/' + book.foto : '/images/no-image.jpg'"
                         class="w-full h-80 object-cover rounded-2xl" id="modalBookImage">

                    <h3 class="text-2xl font-bold mt-6" id="modalBookTitle"></h3>
                    <p class="text-gray-400" id="modalBookAuthor"></p>

                    <div class="mt-6 bg-gray-800 rounded-2xl p-5">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Stok Tersedia</span>
                            <span class="font-bold text-emerald-400" id="modalBookStok"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Form Peminjaman -->
            <div class="w-7/12 p-8">
                <h2 class="text-2xl font-semibold mb-6">Ajukan Peminjaman</h2>

                <form action="{{ route('user.pinjam.store') }}" method="POST" id="pinjamForm">
                    @csrf
                    <input type="hidden" name="book_id" id="modalBookId">

                    <div class="space-y-6">

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Lama Peminjaman (Maks 20 hari)</label>
                            <input type="number" name="hari" id="hari" min="1" max="20"
                                   class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white" required>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-10">
                        <button type="button" onclick="closeModal()"
                                class="flex-1 bg-gray-700 hover:bg-gray-600 py-4 rounded-2xl font-medium transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl font-medium transition">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openPinjamModal(book) {
    document.getElementById('modalBookId').value = book.id;
    document.getElementById('modalBookTitle').textContent = book.judul;
    document.getElementById('modalBookAuthor').textContent = book.penulis;
    document.getElementById('modalBookStok').textContent = book.stok + " eksemplar";

    if (book.foto) {
        document.getElementById('modalBookImage').src = '/storage/books/' + book.foto;
    }

    document.getElementById('pinjamModal').classList.remove('hidden');
    document.getElementById('pinjamModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('pinjamModal').classList.add('hidden');
    document.getElementById('pinjamModal').classList.remove('flex');
}
</script>
