<!-- Modal Kembalikan -->
<div id="kembalikanModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/70">
    <div class="bg-gray-800 rounded-3xl max-w-lg w-full mx-4 overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold">Konfirmasi Pengembalian</h2>
            <button onclick="closeKembalikanModal()" class="text-gray-400 hover:text-white text-xl leading-none">&times;</button>
        </div>

        <!-- Body -->
        <div class="flex gap-4 p-6">
            <img id="kembalikanBookImage" src="/images/no-image.jpg"
                 class="w-24 h-32 object-cover rounded-2xl flex-shrink-0">
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-white text-base leading-tight line-clamp-2" id="kembalikanBookTitle"></h3>
                <p class="text-gray-400 text-sm mt-1" id="kembalikanBookAuthor"></p>
                <div class="mt-3 space-y-1.5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tgl Pinjam</span>
                        <span class="font-medium text-white" id="kembalikanTglPinjam"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Batas Kembali</span>
                        <span class="font-medium text-white" id="kembalikanTglKembali"></span>
                    </div>
                    <div class="flex justify-between border-t border-gray-700 pt-2 mt-2">
                        <span class="text-gray-400">Sisa Waktu</span>
                        <span class="font-bold" id="kembalikanSisaHari"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning terlambat -->
        <div id="kembalikanWarning" class="hidden mx-6 mb-4 bg-red-500/10 border border-red-500/30 rounded-2xl px-4 py-3 text-center text-sm">
            <i class="fas fa-exclamation-triangle text-red-400 mr-1"></i>
            <span class="text-red-400" id="kembalikanWarningText"></span>
        </div>

        <!-- Info menunggu konfirmasi admin -->
        <div class="mx-6 mb-4 bg-blue-500/10 border border-blue-500/30 rounded-2xl px-4 py-3 text-center text-sm">
            <i class="fas fa-info-circle text-blue-400 mr-1"></i>
            <span class="text-blue-300">Pengembalian akan menunggu konfirmasi dari admin.</span>
        </div>

        <!-- Footer -->
        <div class="px-6 pb-6">
            <p class="text-gray-400 text-sm text-center mb-4">Pastikan buku dalam kondisi baik sebelum dikembalikan.</p>
            <form id="kembalikanForm" method="POST">
                @csrf
                <div class="flex gap-3">
                    <button type="button" onclick="closeKembalikanModal()"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 py-3 rounded-2xl text-sm font-medium transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 py-3 rounded-2xl text-sm font-medium transition">
                        Ya, Ajukan Pengembalian
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
function openKembalikanModal(p) {
    document.getElementById('kembalikanBookImage').src =
        p.foto ? '/storage/books/' + p.foto : '/images/no-image.jpg';

    document.getElementById('kembalikanBookTitle').textContent = p.judul;
    document.getElementById('kembalikanBookAuthor').textContent = p.penulis;
    document.getElementById('kembalikanTglPinjam').textContent = p.tgl_pinjam;
    document.getElementById('kembalikanTglKembali').textContent = p.tgl_kembali;

    const sisaEl = document.getElementById('kembalikanSisaHari');
    const warningEl = document.getElementById('kembalikanWarning');
    const warningTextEl = document.getElementById('kembalikanWarningText');

    if (p.sisa_hari < 0) {
        sisaEl.textContent = 'Terlambat ' + Math.abs(p.sisa_hari) + ' hari';
        sisaEl.className = 'font-bold text-red-400';
        warningEl.classList.remove('hidden');
        warningTextEl.textContent = 'Buku terlambat ' + Math.abs(p.sisa_hari) + ' hari. Akan dikenakan denda Rp ' + (Math.abs(p.sisa_hari) * 1000).toLocaleString('id-ID') + '.';
    } else if (p.sisa_hari <= 3) {
        sisaEl.textContent = 'Sisa ' + p.sisa_hari + ' hari';
        sisaEl.className = 'font-bold text-yellow-400';
        warningEl.classList.add('hidden');
    } else {
        sisaEl.textContent = 'Sisa ' + p.sisa_hari + ' hari';
        sisaEl.className = 'font-bold text-emerald-400';
        warningEl.classList.add('hidden');
    }

    document.getElementById('kembalikanForm').action = '/user/kembalikan/' + p.id;

    const modal = document.getElementById('kembalikanModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeKembalikanModal() {
    const modal = document.getElementById('kembalikanModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('kembalikanModal').addEventListener('click', function(e) {
    if (e.target === this) closeKembalikanModal();
});
</script>
