@extends('layouts.user')

@section('title', 'Beranda')

@section('user-content')

{{-- HERO --}}
<section class="relative h-[480px] rounded-2xl overflow-hidden mb-12">
    <img src="/assets/banner.jpg" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
        <h1 class="text-4xl md:text-6xl font-bold drop-shadow-lg text-background">
            Selamat Datang di R.Store
        </h1>
        <p class="text-lg md:text-xl text-background/80 mt-4 max-w-2xl">
            Temukan produk terbaik dari toko pilihan.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6">

    {{-- TOKO PILIHAN --}}
    <h2 class="text-2xl font-bold mb-6 text-text-primary">Toko Pilihan</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($tokos as $t)
            <div class="text-center group">
                <a href="#">
                    <img src="{{ asset('storage/image/'.$t->gambar) }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-border shadow-md mx-auto transition-all group-hover:scale-105">
                </a>
                <p class="mt-3 text-text-primary font-semibold">{{ $t->nama_toko }}</p>
            </div>
        @empty
            <p class="text-text-secondary">Belum ada toko.</p>
        @endforelse
    </div>

    {{-- PRODUK TERBARU --}}
    <h2 class="text-2xl font-bold mt-16 mb-6 text-text-primary">Produk Terbaru</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-20">
        @forelse($produks as $p)
            <div class="bg-surface rounded-xl shadow hover:shadow-lg transition border border-border overflow-hidden">
                <img src="{{ asset('storage/imageproduk/'.$p->Gambar->first()->path_gambar) }}"
                     class="h-48 w-full object-cover">

                <div class="p-4">
                    <h3 class="font-bold text-text-primary line-clamp-2">{{ $p->nama_produk }}</h3>
                    <p class="text-sm text-text-secondary mt-1">Toko: {{ $p->toko->nama_toko }}</p>
                    <p class="text-xl font-bold text-accent mt-2">
                        Rp {{ number_format($p->harga_produk, 0, ',', '.') }}
                    </p>
                    <a href="#" class="mt-4 block bg-secondary text-primary py-2 rounded-lg text-center hover:bg-secondary/90">
                        Detail Produk
                    </a>
                </div>
            </div>
        @empty
            <p class="text-text-secondary">Belum ada produk terbaru.</p>
        @endforelse
    </div>

</div>

@endsection
