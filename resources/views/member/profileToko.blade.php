@extends('membe.tamplate')
@section('content')
<style>
    .hero {
        background: url('/assets/banner.jpg') center/cover no-repeat;
        padding: 80px 20px;
        border-radius: 15px;
        color: white;
    }
    .hero-overlay {
        background: rgba(0,0,0,0.55);
        padding: 60px;
        border-radius: 15px;
    }
    .toko-card img {
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>

<div class="container mt-4">

    {{-- HERO --}}
    <div class="hero mb-5">
        <div class="hero-overlay text-center">
            <h2 class="fw-bold">Selamat Datang di Aplikasi Kami</h2>
            <p>Nikmati layanan terbaik dan temukan toko pilihan Anda.</p>
            <a href="#tokoList" class="btn btn-light mt-3">Lihat Toko</a>
        </div>
    </div>

    {{-- LIST TOKO --}}
    <div class="row">
    @forelse ($tokos as $t)
    <div class="col-md-3 mb-4 text-center">

        {{-- FOTO LINGKARAN + LINK KE DETAIL --}}
        <a href="#">
            <img
                src="{{ asset('storage/image/'.$t->gambar) }}"
                class="rounded-circle mb-3"
                style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #ddd;">
        </a>

        {{-- NAMA TOKO --}}
        <h5 class="fw-bold">{{ $t->nama_toko }}</h5>

    </div>
    @empty
    <div class="col-12 text-center">
        <p class="text-muted">Belum ada toko tersedia.</p>
    </div>
    @endforelse
</div>


    {{-- PRODUK TERBARU --}}
    <h4 class="mt-5 mb-3 fw-bold">Produk Terbaru</h4>

    <div class="row">
        @forelse ($produks as $p)
        <div class="col-md-3 mb-4">
            <div class="card shadow">

                <img src="{{ asset('storage/image/'.$p->gambar_produk) }}"
                     class="card-img-top "
                     style="height: 180px; object-fit: cover;">

                <div class="card-body">
                    <h6 class="fw-bold">{{ $p->nama_produk }}</h6>

                    <p class="text-muted small mb-1">
                        Toko: {{ $p->toko->nama_toko }}
                    </p>

                    <p class="text-primary fw-bold">
                        Rp {{ number_format($p->harga_produk, 0, ',', '.') }}
                    </p>

                    <a href="#" class="btn btn-outline-primary w-100">Detail Produk</a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted">
            Belum ada produk tersedia.
        </div>
        @endforelse
    </div>

</div>
@endsection
