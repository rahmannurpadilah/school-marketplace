@extends('layouts.user')

@section('title', 'Semua Toko')

@section('user-content')

<div class="max-w-7xl mx-auto px-6">

    {{-- SEARCH --}}
    <form action="" method="GET" class="mb-10">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari toko..."
               class="w-full px-4 py-2 rounded-lg border border-border bg-surface focus:ring-2 focus:ring-accent outline-none">
    </form>

    {{-- LIST TOKO --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-20">

        @forelse($tokos as $t)
            <div class="text-center group bg-surface p-4 rounded-xl shadow border border-border hover:shadow-lg transition">

                <a href="#">
                    <img src="{{ asset('storage/image/'.$t->gambar) }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-border mx-auto transition-all group-hover:scale-105">
                </a>

                <p class="mt-3 text-text-primary font-semibold">
                    {{ $t->nama_toko }}
                </p>

                @if($t->deskripsi)
                <p class="text-sm text-text-secondary mt-1 line-clamp-2">
                    {{ $t->deskripsi }}
                </p>
                @endif

            </div>
        @empty
            <p class="text-text-secondary">Tidak ada toko ditemukan.</p>
        @endforelse

    </div>

</div>

@endsection
