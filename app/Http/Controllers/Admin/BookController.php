<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('kategori'); // relasi

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('penulis', 'like', "%$search%")
                  ->orWhere('penerbit', 'like', "%$search%");
            });
        }

        // ✅ Filter Kategori (FIX)
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $books = $query->latest()->paginate(10);

        // kirim kategori ke view (buat dropdown filter)
        $kategoris = Kategori::all();

        return view('admin.dataBuku', compact('books', 'kategoris'));
    }

    public function create()
    {
        // ✅ ambil kategori buat dropdown
        $kategoris = Kategori::all();

        return view('admin.tambahBuku', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'penerbit'    => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['judul', 'penulis', 'kategori_id', 'penerbit', 'stok']);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->store('books', 'public');
            $data['foto'] = basename($path);
        }

        Book::create($data);   // atau nama model kamu

        return redirect()->route('admin.dataBuku')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        // ✅ ambil kategori buat dropdown edit
        $kategoris = Kategori::all();

        return view('admin.editBuku', compact('book', 'kategoris'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id', // ✅ FIX
            'penerbit'     => 'required|string|max:255',
            'stok'         => 'required|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        // Ganti Foto
        if ($request->hasFile('foto')) {

            if ($book->foto && Storage::disk('public')->exists('books/' . $book->foto)) {
                Storage::disk('public')->delete('books/' . $book->foto);
            }

            $path = $request->file('foto')->store('books', 'public');
            $data['foto'] = basename($path);
        }

        $book->update($data);

        return redirect()->route('admin.dataBuku')
                         ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->foto && Storage::disk('public')->exists('books/' . $book->foto)) {
           Storage::disk('public')->exists('books/' . $book->foto);
        }

        $book->delete();

        return redirect()->route('admin.dataBuku')
                         ->with('success', 'Buku berhasil dihapus!');
    }
}
