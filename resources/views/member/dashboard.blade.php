@extends('layouts.member')
@section('title', 'Dashboard Member')

@section('content')

@if (session('success'))
<div id="alertSuccess"
    class="flex items-center justify-between bg-green-500/20 text-green-700 border border-green-500 
           rounded-lg px-4 py-3 mb-4 animate-fade">
    <span class="text-sm font-medium">{{ session('success') }}</span>

    <button onclick="document.getElementById('alertSuccess').classList.add('hidden')"
        class="ms-4 text-green-700 hover:text-green-900">
        <i data-lucide="x" class="w-5 h-5"></i>
    </button>
</div>
@endif

@if (session('error'))
<div id="alertError"
    class="flex items-center justify-between bg-red-500/20 text-red-600 border border-red-500 
           rounded-lg px-4 py-3 mb-4 animate-fade">
    <span class="text-sm font-medium">{{ session('error') }}</span>

    <button onclick="document.getElementById('alertError').classList.add('hidden')"
        class="ms-4 text-red-600 hover:text-red-800">
        <i data-lucide="x" class="w-5 h-5"></i>
    </button>
</div>
@endif



@php
    $toko = Auth::user()->Toko;
    $jumlahProduk = $toko ? $toko->Produk->count() : 0;

    $jumlahGambar = $toko
        ? \App\Models\Gambar::whereIn('produk_id', $toko->Produk->pluck('id'))->count()
        : 0;

    $jumlahKategori = \App\Models\Kategori::count();
@endphp

@if (!$toko)

<div class="bg-primary border border-border rounded-xl p-8 shadow-md text-center">

    <h2 class="text-2xl font-bold text-textPrimary">Anda Belum Memiliki Toko</h2>
    <p class="text-textPrimary/70 mt-2">Silakan buat toko untuk mulai menjual produk.</p>

    <button class="mt-4 bg-secondary text-background px-4 py-2 rounded-lg"
        onclick="openCreateTokoModal()">
        + Buat Toko
    </button>
</div>

@elseif ($toko->status === 'pending')

<div class="bg-blue-500/20 border border-blue-500 text-blue-700 rounded-lg px-4 py-3 mb-6">
    <strong>Info:</strong> Toko Anda sedang dalam proses peninjauan. Harap tunggu beberapa saat.
</div>

@elseif ($toko->status === 'ditolak')

<div class="bg-red-500/20 border border-red-500 text-red-600 rounded-lg px-4 py-3 mb-4">
    <strong>Ditolak:</strong> Toko Anda ditolak. Silakan perbaiki data toko Anda dan kirim ulang permintaan.
</div>

<button class="bg-orange-500 text-white px-4 py-2 rounded-lg mb-6" onclick="openEditToko()">
    Perbaiki Toko & Kirim Ulang
</button>



@else

<div class="bg-primary border border-border rounded-xl shadow-md p-6 mb-6 flex justify-between items-center">

    <div class="flex gap-4">
        <div>
            @if ($toko->gambar)
                <img src="{{ asset('storage/logotoko/'.$toko->gambar) }}"
                    class="w-24 h-24 rounded-full object-cover border border-border shadow">
            @else
                <img src="https://via.placeholder.com/100"
                    class="w-24 h-24 rounded-full border border-border shadow">
            @endif
        </div>

        <div>
            <h3 class="text-2xl font-bold text-textPrimary">{{ $toko->nama_toko }}</h3>
            <p class="text-textPrimary/70 mt-1 max-w-xl">{{ $toko->deskripsi }}</p>
            <p class="text-textPrimary/70 mt-1 max-w-xl text-sm items-center flex gap-2">
                <i data-lucide="phone-incoming" class="w-4 h-4"></i>
                {{ $toko->kontak_toko }}
            </p>
        </div>
    </div>

    <button class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-accent/90"
        onclick="openEditToko()">
        Edit Toko
    </button>
</div>


<div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">

    <div class="bg-primary border border-border rounded-xl shadow-md p-6 flex items-center justify-between 
                hover:shadow-lg transition duration-300">

        <div>
            <h5 class="text-textSecondary font-semibold">Jumlah Produk</h5>
            <h2 class="text-3xl font-bold mt-2">{{ $jumlahProduk }}</h2>
        </div>

        <div class="p-4 bg-secondary/10 rounded-xl">
            <i data-lucide="package" class="w-10 h-10 text-secondary"></i>
        </div>
    </div>

    <div class="bg-primary border border-border rounded-xl shadow-md p-6 flex items-center justify-between 
                hover:shadow-lg transition duration-300">

        <div>
            <h5 class="text-textSecondary font-semibold">Total Gambar Produk</h5>
            <h2 class="text-3xl font-bold mt-2">{{ $jumlahGambar }}</h2>
        </div>

        <div class="p-4 bg-secondary/10 rounded-xl">
            <i data-lucide="image" class="w-10 h-10 text-secondary"></i>
        </div>
    </div>

    <div class="bg-primary border border-border rounded-xl shadow-md p-6 flex items-center justify-between 
                hover:shadow-lg transition duration-300">

        <div>
            <h5 class="text-textSecondary font-semibold">Jumlah Kategori</h5>
            <h2 class="text-3xl font-bold mt-2">{{ $jumlahKategori }}</h2>
        </div>

        <div class="p-4 bg-secondary/10 rounded-xl">
            <i data-lucide="list" class="w-10 h-10 text-secondary"></i>
        </div>
    </div>

</div>

@endif

<div id="createTokoModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-primary border border-border rounded-xl shadow-xl w-full max-w-2xl p-6">

        <div class="flex justify-between items-center border-b border-border pb-3 mb-4">
            <h3 class="text-lg font-bold text-textPrimary">Buat Toko Baru</h3>
            <button onclick="closeCreateTokoModal()">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form action="{{ route('member.toko.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-4">
                <div>
                    <label class="font-medium">Nama Toko</label>
                    <input type="text" name="nama_toko" class="bg-background border border-border rounded-lg w-full p-2.5">
                </div>

                <div>
                    <label class="font-medium">Alamat Toko</label>
                    <input type="text" name="alamat" class="bg-background border border-border rounded-lg w-full p-2.5">
                </div>

                <div>
                    <label class="font-medium">Deskripsi</label>
                    <textarea name="deskripsi" class="bg-background border border-border rounded-lg w-full p-2.5"></textarea>
                </div>

                <div>
                    <label class="font-medium">Logo Toko</label>
                    <input type="file" name="logo_toko"
                        class="bg-background border border-border rounded-lg w-full p-2.5">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeCreateTokoModal()"
                    class="px-4 py-2 bg-background border border-border rounded-lg">
                    Batal
                </button>

                <button class="px-4 py-2 bg-secondary text-background rounded-lg">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>

@if ($toko)
<div id="EditToko" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-primary border border-border rounded-xl shadow-xl w-full max-w-2xl p-6">

        <div class="flex justify-between items-center border-b border-border pb-3 mb-4">
            <h3 class="text-lg font-bold text-textPrimary">Edit Toko</h3>
            <button onclick="closeEditToko()">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form action="{{ route('member.toko.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $toko->id }}">

            <div class="grid gap-4">
                <div>
                    <label class="font-medium">Nama Toko</label>
                    <input type="text" name="nama_toko" value="{{ $toko->nama_toko }}"
                        class="bg-background border border-border rounded-lg w-full p-2.5">
                </div>

                <div>
                    <label class="font-medium">Deskripsi</label>
                    <textarea name="deskripsi" class="bg-background border border-border rounded-lg w-full p-2.5"
                        >{{ $toko->deskripsi }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Ganti Logo</label>
                    <input type="file" name="logo_toko"
                        class="bg-background border border-border rounded-lg w-full p-2.5">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditToko()"
                    class="px-4 py-2 bg-background border border-border rounded-lg">
                    Batal
                </button>

                <button class="px-4 py-2 bg-secondary text-background rounded-lg">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endif

<script>

setTimeout(() => {
    let s = document.getElementById('alertSuccess');
    let e = document.getElementById('alertError');

    if (s) s.classList.add('hidden');
    if (e) e.classList.add('hidden');
}, 3000);


function openCreateTokoModal() {
    document.getElementById('createTokoModal').classList.remove('hidden');
}
function closeCreateTokoModal() {
    document.getElementById('createTokoModal').classList.add('hidden');
}

function openEditToko() {
    document.getElementById('EditToko').classList.remove('hidden');
}
function closeEditToko() {
    document.getElementById('EditToko').classList.add('hidden');
}

lucide.createIcons();

</script>

@endsection
