@extends('layouts.member')

@section('title', 'Kategori Produk')

@section('content')

<div class="bg-primary shadow-sm rounded-xl border border-border overflow-hidden">

    {{-- ================== ALERT SUCCESS ================== --}}
    @if (session('success'))
    <div id="alertSuccess"
        class="flex items-center justify-between bg-green-500/20 text-green-700 border border-green-500 rounded-lg px-4 py-3 mb-4 animate-fade">
        <span class="text-sm font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('alertSuccess').classList.add('hidden')"
            class="ms-4 text-green-700 hover:text-green-900">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    @endif

    {{-- ================== ALERT ERROR ================== --}}
    @if (session('error'))
    <div id="alertError"
        class="flex items-center justify-between bg-red-500/20 text-red-600 border border-red-500 rounded-lg px-4 py-3 mb-4 animate-fade">
        <span class="text-sm font-medium">{{ session('error') }}</span>
        <button onclick="document.getElementById('alertError').classList.add('hidden')"
            class="ms-4 text-red-600 hover:text-red-800">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    @endif

    {{-- ================= SEARCH ONLY ================= --}}
    <div class="p-4 flex items-center gap-4 justify-between">

        {{-- SEARCH --}}
        <div class="relative w-full max-w-md">
            <span class="absolute inset-y-0 left-3 flex items-center text-textPrimary/60">
                <i data-lucide="search" class="w-4 h-4"></i>
            </span>
            <input 
                type="text" 
                id="searchKategori"
                class="w-full ps-9 pe-3 py-2 bg-background border border-border rounded-lg text-sm focus:ring-accent focus:border-accent"
                placeholder="Cari kategori..."
                onkeyup="filterKategori()">
        </div>

        {{-- NO BUTTON ADD FOR MEMBER --}}
    </div>

    {{-- ================= TABLE ================= --}}
    <table class="w-full text-sm text-left">

        <thead class="bg-background border-y border-border">
            <tr>
                <th class="px-6 py-3 font-medium">No</th>
                <th class="px-6 py-3 font-medium">Nama Kategori</th>
            </tr>
        </thead>

        <tbody id="kategoriTable">
            @php $no = 1; @endphp
            @foreach($kategori as $k)
            <tr class="bg-primary border-b border-border hover:bg-background transition">

                <td class="px-6 py-4">{{ $no++ }}</td>

                <td class="px-6 py-4">{{ $k->nama_kategori }}</td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>

<script>

    // Auto close alerts
    setTimeout(() => {
        let s = document.getElementById('alertSuccess');
        let e = document.getElementById('alertError');
        if (s) s.classList.add('hidden');
        if (e) e.classList.add('hidden');
    }, 3000);

function filterKategori() {
    let search = document.getElementById('searchKategori').value.toLowerCase();
    let rows = document.querySelectorAll('#kategoriTable tr');

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
}

lucide.createIcons();

</script>

@endsection
