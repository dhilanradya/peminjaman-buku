<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('kelas', 'like', "%$search%");
            });
        }

        $members = $query->latest()->paginate(10);

        return view('admin.dataAnggota', compact('members'));
    }

    public function create()
    {
        return view('admin.tambahAnggota');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nis'      => 'required|string|unique:users,nis',
            'kelas'    => 'required|string|max:50',
            'no_hp'    => 'required|string|max:20',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nama'     => $request->nama,
            'nis'      => $request->nis,
            'kelas'    => $request->kelas,
            'no_hp'    => $request->no_hp,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('admin.dataAnggota')
                         ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(User $member)
    {
        return view('admin.editAnggota', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nis'      => 'required|string|unique:users,nis,' . $member->id,
            'kelas'    => 'required|string|max:50',
            'no_hp'    => 'required|string|max:20',
            'email'    => 'required|email|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'nama'  => $request->nama,
            'nis'   => $request->nis,
            'kelas' => $request->kelas,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.dataAnggota')
                         ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(User $member)
    {
        if ($member->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin!');
        }

        $member->delete();

        return redirect()->route('admin.dataAnggota')
                         ->with('success', 'Anggota berhasil dihapus!');
    }
}
