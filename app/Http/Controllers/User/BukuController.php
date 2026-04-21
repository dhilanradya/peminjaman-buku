<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('kategori');

        // 🔍 Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('penulis', 'like', "%$search%");
            });
        }

        // 📂 Filter kategori
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $books = $query->latest()->paginate(50)->withQueryString();
        $kategoris = Kategori::all();

        return view('user.buku', compact('books', 'kategoris'));
    }
}
