@extends('layouts.user')

@section('title', 'Produk')

@section('user-content')

<div class="max-w-7xl mx-auto px-6">

    {{-- SEARCH + FILTER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">

        {{-- SEARCH --}}
        <form action="" method="GET" class="flex items-center w-full md:w-1/2">
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari produk..."
                   class="w-full px-4 py-2 rounded-lg border border-border bg-surface focus:ring-2 focus:ring-accent outline-none">
        </form>

        {{-- FILTER KATEGORI --}}
        <form action="" method="GET">
            <select name="kategori"
                    onchange="this.form.submit()"
                    class="px-4 py-2 rounded-lg border border-border bg-surface focus:ring-2 focus:ring-accent outline-none">
                <option value="">Semua Kategori</option>

                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}"
                        {{ request('kategori') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </form>

    </div>

    {{-- LIST PRODUK --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-20">
        @forelse($produks as $p)
            <div class="bg-surface rounded-xl shadow hover:shadow-lg transition border border-border overflow-hidden">
                <img src="{{ asset('storage/imageproduk/'.$p->Gambar->first()->path_gambar) }}"
                     class="h-48 w-full object-cover">

                <div class="p-4">
                    <h3 class="font-bold text-text-primary line-clamp-2">{{ $p->nama_produk }}</h3>

                    <p class="text-sm text-text-secondary mt-1">
                        Toko: {{ $p->toko->nama_toko }}
                    </p>

                    <p class="text-xl font-bold text-accent mt-2">
                        Rp {{ number_format($p->harga_produk, 0, ',', '.') }}
                    </p>

                    <a href="#"
                       class="mt-4 block bg-secondary text-primary py-2 rounded-lg text-center hover:bg-secondary/90">
                        Detail Produk
                    </a>
                </div>
            </div>
        @empty
            <p class="text-text-secondary">Tidak ada produk ditemukan.</p>
        @endforelse
    </div>

</div>

@endsection
