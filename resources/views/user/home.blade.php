@extends('layouts.user')

@section('title', 'Beranda')

@section('user-content')

<section>
    <div class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32 mb-16 rounded-2xl">
    
        <img 
            src="/assets/banner.jpg"
            class="absolute inset-0 -z-10 w-full h-full object-cover object-center"
        />
    
        <div class="absolute inset-0 bg-black/60 -z-10"></div>
    
        <div aria-hidden="true" 
            class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:block sm:transform-gpu sm:blur-3xl">
            <div style="clip-path: polygon(74.1% 44.1%,100% 61.6%,97.5% 26.9%,85.5% 0.1%,80.7% 2%,72.5% 32.5%,60.2% 62.4%,52.4% 68.1%,47.5% 58.3%,45.2% 34.5%,27.5% 76.7%,0.1% 64.9%,17.9% 100%,27.6% 76.8%,76.1% 97.7%,74.1% 44.1%)"
                 class="aspect-1097/845 w-96 bg-gradient-to-tr from-pink-500 to-purple-500 opacity-20">
            </div>
        </div>
    
        <div aria-hidden="true" 
            class="absolute -top-40 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:-top-80 sm:translate-x-0">
            <div style="clip-path: polygon(74.1% 44.1%,100% 61.6%,97.5% 26.9%,85.5% 0.1%,80.7% 2%,72.5% 32.5%,60.2% 62.4%,52.4% 68.1%,47.5% 58.3%,45.2% 34.5%,27.5% 76.7%,0.1% 64.9%,17.9% 100%,27.6% 76.8%,76.1% 97.7%,74.1% 44.1%)"
                 class="aspect-1097/845 w-96 bg-gradient-to-tr from-purple-500 to-blue-500 opacity-20">
            </div>
        </div>
    
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-6xl font-bold tracking-tight text-white drop-shadow">
                Selamat Datang di R.Store
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-gray-300 max-w-2xl mx-auto">
                Temukan produk terbaik dari toko pilihan sekolah, semua ada dalam satu platform.
            </p>
    
            <div class="mt-10 flex justify-center gap-6">
                <a href="#produk-terbaru" 
                   class="px-6 py-3 bg-secondary text-background rounded-lg font-semibold hover:bg-secondary/90 transition">
                    Jelajahi Produk
                </a>
                <a href="#toko-terbaru" 
                   class="px-6 py-3 bg-white/10 text-white border border-white/20 rounded-lg hover:bg-white/20 transition">
                    Toko Terbaru
                </a>
            </div>
        </div>
    
    </div>
</section>


<div class="max-w-7xl mx-auto px-6">

    <h2 class="text-2xl font-bold mb-6 text-text-primary" id="toko-terbaru">Toko Terbaru</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($tokos as $t)
            <div class="text-center group">
                <a href={{ route('detail.toko', ['id' => Crypt::encrypt($t->id)]) }}>
                    <img src="{{ asset('storage/logotoko/'.$t->gambar) }}"
                         class="w-32 h-32 rounded-xl object-cover border-4 border-border shadow-md mx-auto transition-all group-hover:scale-105">
                </a>
                <p class="mt-3 text-text-primary font-semibold">{{ $t->nama_toko }}</p>
            </div>
        @empty
            <p class="text-text-secondary">Belum ada toko.</p>
        @endforelse
    </div>

    <h2 class="text-2xl font-bold mt-16 mb-6 text-text-primary" id="produk-terbaru">Produk Terbaru</h2>

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
                    <a href={{  route('detail.produk', ['id' => Crypt::encrypt($p->id)])  }} class="mt-4 block bg-secondary text-background py-2 rounded-lg text-center hover:bg-secondary/90">
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
