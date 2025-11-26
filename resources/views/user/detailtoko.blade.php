@extends('layouts.user')

@section('title', 'Detail Toko')

@section('user-content')

@php
    $wa = preg_replace('/[^0-9]/', '', $toko->kontak_toko);
    if (str_starts_with($wa, '0')) {
        $wa = '62' . substr($wa, 1);
    }
@endphp


<section class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32 mb-16 rounded-2xl">

    <img 
        src="{{ asset('storage/logotoko/'.$toko->gambar) }}" 
        class="absolute inset-0 -z-10 w-full h-full object-cover opacity-40"
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

    <div class="relative mx-auto max-w-4xl px-6 lg:px-8 text-center">

        <img src="{{ asset('storage/logotoko/'.$toko->gambar) }}"
             class="w-40 h-40 rounded-xl object-cover border-4 border-white shadow-xl mx-auto mb-6">

        <h1 class="text-4xl sm:text-6xl font-bold tracking-tight text-white drop-shadow">
            {{ $toko->nama_toko }}
        </h1>

        <p class="mt-6 text-lg sm:text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
            {{ $toko->deskripsi ?? 'Toko ini belum memiliki deskripsi.' }}
        </p>

        <div class="mt-6 text-gray-300 flex flex-col sm:flex-row justify-center gap-4 text-sm sm:text-base">
            <p><strong>Kontak:</strong> {{ $toko->kontak_toko }}</p>
            <p><strong>Alamat:</strong> {{ $toko->alamat }}</p>
        </div>

        <div class="mt-10 flex justify-center">
            <a href="https://wa.me/{{ $wa }}?text=Halo%20saya%20ingin%20bertanya%20tentang%20produk%20di%20{{ urlencode($toko->nama_toko) }}."
               target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-lg hover:bg-green-600 transition">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                Chat via WhatsApp
            </a>
        </div>

    </div>

</section>

<div class="max-w-7xl mx-auto px-6">

    <h2 class="text-2xl font-bold mb-8 text-text-primary">
        Produk dari {{ $toko->nama_toko }}
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-20">

        @forelse($produk as $p)
            <div class="bg-surface rounded-xl shadow hover:shadow-lg transition border border-border overflow-hidden">
                <img src="{{ asset('storage/imageproduk/'.$p->Gambar->first()->path_gambar) }}"
                     class="h-48 w-full object-cover">

                <div class="p-4">
                    <h3 class="font-bold text-text-primary line-clamp-2">{{ $p->nama_produk }}</h3>
                    <p class="text-sm text-text-secondary mt-1">Kategori: {{ $p->Kategori->nama_kategori ?? '-' }}</p>

                    <p class="text-xl font-bold text-accent mt-2">
                        Rp {{ number_format($p->harga_produk, 0, ',', '.') }}
                    </p>

                    <a href="{{  route('detail.produk', ['id' => Crypt::encrypt($p->id)])  }}"
                       class="mt-4 block bg-secondary text-background py-2 rounded-lg text-center hover:bg-secondary/90">
                        Detail Produk
                    </a>
                </div>
            </div>

        @empty
            <p class="text-text-secondary">Belum ada produk dari toko ini.</p>
        @endforelse

    </div>

</div>

<script>
    lucide.createIcons();
</script>

@endsection
