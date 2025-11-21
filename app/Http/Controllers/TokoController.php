<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TokoController extends Controller
{
    //

    //admin
    public function index()
    {
        $tokos = Toko::with('user')->get();  // mengambil relasi user
        $users = User::all();   // untuk dropdown memilih pemilik toko
        return view('admin.toko', compact('tokos', 'users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko'    => 'required',
            'deskripsi'    => 'required',
            'gambar'       => 'required|image',
            'user_id'      => 'required',
            'kontak_toko'  => 'required',
            'alamat'       => 'required'
        ]);

        // Upload gambar
        $file = $request->file('gambar');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('storage/image'), $namaFile);

        if (Toko::where('user_id', $request->user_id)->exists()) {
            return back()->with('error', 'User sudah memiliki toko!');
        }

        Toko::create([
            'nama_toko'    => $request->nama_toko,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => $namaFile,
            'user_id'      => $request->user_id,
            'status'       => 'active',
            'kontak_toko'  => $request->kontak_toko,
            'alamat'       => $request->alamat,
        ]);

        return back()->with('success', 'Toko berhasil ditambahkan!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'id'           => 'required',
            'nama_toko'    => 'required',
            'deskripsi'    => 'required',
            'user_id'      => 'required',
            'kontak_toko'  => 'required',
            'alamat'       => 'required'
        ]);

        $toko = Toko::findOrFail($request->id);

        // Jika user upload gambar baru
        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            $oldPath = public_path('storage/image/'.$toko->gambar);
            if(File::exists($oldPath)){ File::delete($oldPath); }

            $file = $request->file('gambar');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('storage/image'), $namaFile);

            $toko->gambar = $namaFile;
        }

        $toko->nama_toko    = $request->nama_toko;
        $toko->deskripsi    = $request->deskripsi;
        $toko->user_id      = $request->user_id;
        $toko->kontak_toko  = $request->kontak_toko;
        $toko->alamat       = $request->alamat;
        $toko->save();

        return back()->with('success', 'Data toko berhasil diupdate!');
    }
    public function delete($id)
    {
        $toko = Toko::findOrFail($id);

        // hapus gambar
        $oldPath = public_path('storage/image/'.$toko->gambar);
        if(File::exists($oldPath)){ File::delete($oldPath); }

        $toko->delete();

        return back()->with('success', 'Toko berhasil dihapus!');
    }
    public function approve($id)
    {
        $toko = Toko::findOrFail($id);
        $toko->status = 'active';
        $toko->save();

        return redirect()->back()->with('success', 'Toko berhasil diapprove!');
    }
}
