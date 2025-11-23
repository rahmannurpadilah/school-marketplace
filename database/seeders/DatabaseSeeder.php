<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Toko;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'kontak' => '0870779797',
            'username' => 'admin1',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
        Toko::create([
            'user_id' => 1,
            'nama_toko' => 'Kocak Store',
            'alamat' => 'Jl. Anggrek No. 23',
            'status' => 'active',
            'gambar' => 'public/storage/image/sekolah1.jpg',
            'deskripsi' => 'Toko resmi Kurumi Store menjual berbagai kebutuhan rumah tangga dan elektronik.',
            'kontak_toko' => '0870779797',
        ]);
        Kategori::create([
            'nama_kategori' => 'Elektro'
        ]);
    }
}
