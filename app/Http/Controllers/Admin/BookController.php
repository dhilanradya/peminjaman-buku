<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('penulis', 'like', "%$search%")
                  ->orWhere('penerbit', 'like', "%$search%");
            });
        }

        // Filter Kategori
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $books = $query->latest()->paginate(10);

        return view('admin.dataBuku', compact('books'));
    }

    public function create()
    {
        return view('admin.tambahBuku');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'kategori'  => 'required|in:Fiksi,Non-Fiksi,Pendidikan',
            'penerbit'  => 'required|string|max:255',
            'stok'      => 'required|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        // ✅ UPLOAD FOTO (FIX)
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('books', 'public');
            $data['foto'] = basename($path);
        }

        Book::create($data);

        return redirect()->route('admin.dataBuku')
                         ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        return view('admin.editBuku', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'kategori'  => 'required|in:Fiksi,Non-Fiksi,Pendidikan',
            'penerbit'  => 'required|string|max:255',
            'stok'      => 'required|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        // ✅ GANTI FOTO
        if ($request->hasFile('foto')) {

            // Hapus foto lama
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
        // Hapus foto
        if ($book->foto && Storage::disk('public')->exists('books/' . $book->foto)) {
            Storage::disk('public')->delete('books/' . $book->foto);
        }

        $book->delete();

        return redirect()->route('admin.dataBuku')
                         ->with('success', 'Buku berhasil dihapus!');
    }
}
