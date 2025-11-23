<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class adminController extends Controller
{
    //
    public function dashboard()
    {
        $data['users'] = User::count();
        $data['tokos'] = Toko::count();
        $data['produks'] = Produk::count();

        return view('admin.dashboard', $data);
    }

    public function userAdmin(){
        $data['users'] = User::all();
        return view('admin.useradmin',$data);
    }
    public function loginView(){
        return view('login');
    }

    public function login(Request $request)
    {
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    if (Auth::attempt($request->only('username', 'password'))) {

        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'member') {
            return redirect()->route('user.dashboard');
        }
        return redirect()->route('login')->with('error', 'Role tidak dikenal.');
    }
    return back()->with('error', 'Email atau password salah.');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function regisview(){
        return view('registrasi');
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string',
        ]);
        User::create([
            'name' => $request->name,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'role' => 'member',
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('login')->with('succsess','registrasi berhasil,silahkan login');
    }
    public function addmember(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string',
            'role' => 'required'
        ]);
        User::create([
            'name' => $request->name,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->back()->with('succsess','member berhasil di tambah');
    }
    public function updateMember(Request $req)
    {
    User::where('id', $req->id)->update([
        'name' => $req->name,
        'kontak' => $req->kontak,
        'username' => $req->username,
        'password' => bcrypt($req->password),
        'role' => $req->role,
    ]);

        return back()->with('succsess','Member berhasil diperbarui!');
    }
    public function deleteMember($id)
    {
        Gambar::whereHas('produk', function ($query) use ($id) {
            $query->where('toko_id', $id);
        })->delete();
        Produk::where('toko_id',$id)->delete();
        Toko::where('user_id',$id)->delete();
        User::find($id)->delete();

        return back()->with('succsess','Member berhasil dihapus!');
    }
    public function edit($id)
    {
        $kategoriEdit = Kategori::findOrFail($id);
        $kategori = Kategori::all();

        return view('admin.kategori', compact('kategori', 'kategoriEdit'));
    }
    public function produk(){
        $data['produks'] = Produk::with('Kategori','Toko')->get();
        $data['kategori'] = Kategori::all();
        return view('admin.produk',$data);
    }

    public function produkdelete($id){
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

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}
