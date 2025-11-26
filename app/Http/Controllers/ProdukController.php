<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProdukController extends Controller
{
    //
   public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategoris,id',
            'harga_produk'  => 'required|numeric',
            'stok'          => 'required|integer',
            'deskripsi_produk' => 'required|string',
            'gambar_produk.*'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Pastikan user punya toko
        if (!Auth::user()->Toko) {
            return redirect()->back()->with('error', 'Anda belum memiliki toko.');
        }

        // Buat produk
        $produk = Produk::create([
            'nama_produk'       => $request->nama_produk,
            'kategori_id'       => $request->kategori_id,
            'harga_produk'      => $request->harga_produk,
            'stok'              => $request->stok,
            'deskripsi_produk'  => $request->deskripsi_produk,
            'toko_id'           => Auth::user()->Toko->id,
            'tanggal_upload'    => now(), // WAJIB!
        ]);

        // Upload banyak gambar
        if ($request->hasFile('gambar_produk')) {

            foreach ($request->file('gambar_produk') as $file) {

                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/imageproduk'), $namaFile);

                Gambar::create([
                    'produk_id'   => $produk->id,
                    'path_gambar' => $namaFile,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update (Request $request){
        $request->validate([
            'id'             => 'required|exists:produks,id',
            'nama_produk'   => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategoris,id',
            'harga_produk'  => 'required|numeric',
            'stok'          => 'required|integer',
            'deskripsi_produk' => 'required|string',
        ]);

        $produk = Produk::find($request->id);
        $produk->update([
            'nama_produk'       => $request->nama_produk,
            'kategori_id'       => $request->kategori_id,
            'harga_produk'      => $request->harga_produk,
            'stok'              => $request->stok,
            'deskripsi_produk'  => $request->deskripsi_produk,
        ]);

        if ($request->hasFile('gambar_produk')) {

            foreach ($request->file('gambar_produk') as $file) {

                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('imageproduk', $namaFile);

                Gambar::create([
                    'produk_id' => $produk->id,
                    'path_gambar' => $namaFile,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Produk berhasil diupdate!');
    }
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->Gambar && $produk->Gambar->count() > 0) {

            foreach ($produk->Gambar as $gambar) {

                $path = public_path('storage/imageproduk/' . $gambar->path_gambar);

                if (file_exists($path)) {
                    unlink($path);
                }

                $gambar->delete();
            }
        }
        $produk->delete();

        return back()->with('success', 'Produk dan semua gambar berhasil dihapus.');
    }


    public function detail($id)
    {
        $decryptId = Crypt::decrypt($id);

        $produk = Produk::with(['Gambar', 'Kategori'])->findOrFail($decryptId);

        $data['produk'] = $produk;
        $data['gambar'] = $produk->Gambar;

        return view('member.produkdetail', $data);
    }

}
