@extends('layouts.user')

@section('title', 'Detail Produk')

@section('user-content')

@php
    $wa = preg_replace('/[^0-9]/', '', $toko->kontak_toko ?? '');
    if ($wa && str_starts_with($wa, '0')) {
        $wa = '62' . substr($wa, 1);
    }

    $pesan = urlencode("Halo, saya ingin bertanya tentang produk *{$produk->nama_produk}*.");
@endphp

<div class="bg-primary shadow-sm rounded-xl border border-border overflow-hidden p-6">

    <a href="{{ route('user.dashboard') }}"
        class="inline-flex items-center text-textSecondary hover:underline mb-5">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <div>

            <div class="w-full h-80 bg-background border border-border rounded-lg overflow-hidden">
                <img id="mainImage"
                     src="{{ asset('storage/imageproduk/' . ($gambar->first()->path_gambar ?? 'default.jpg')) }}"
                     class="w-full h-full object-cover">
            </div>

            @if ($gambar->count() > 1)
            <div class="flex gap-3 mt-4">

                @foreach($gambar as $gm)
                <img src="{{ asset('storage/imageproduk/' . $gm->path_gambar) }}"
                     onclick="document.getElementById('mainImage').src=this.src"
                     class="w-20 h-20 object-cover border border-border rounded-lg cursor-pointer hover:opacity-80 transition">
                @endforeach

            </div>
            @endif

        </div>



        <div class="flex flex-col gap-4">

            <h1 class="text-2xl font-bold text-textPrimary">
                {{ $produk->nama_produk }}
            </h1>

            <div class="text-3xl font-extrabold text-accent">
                Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
            </div>

            <div class="flex flex-col gap-1 text-sm">
                <p class="text-textPrimary">
                    Stok: <span class="font-semibold">{{ $produk->stok }}</span>
                </p>

                <p class="text-textPrimary">
                    Kategori:
                    <span class="font-semibold">{{ $produk->Kategori->nama_kategori ?? 'Tidak ada kategori' }}</span>
                </p>

                <p class="text-textPrimary">
                    Toko:
                    <a href="{{ route('detail.toko', Crypt::encrypt($toko->id)) }}"
                       class="underline hover:text-accent">
                        {{ $toko->nama_toko }}
                    </a>
                </p>
            </div>

            <div class="mt-4">
                <h3 class="font-semibold text-textPrimary mb-2">Deskripsi Produk</h3>

                <div class="bg-background border border-border rounded-lg p-4 text-sm leading-relaxed">
                    {!! nl2br(e($produk->deskripsi_produk)) !!}
                </div>
            </div>

            <div class="mt-6">
                <a href="https://wa.me/{{ $wa }}?text={{ $pesan }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    Chat via WhatsApp
                </a>
            </div>

        </div>

    </div>

</div>

<script>
    lucide.createIcons();
</script>

@endsection
