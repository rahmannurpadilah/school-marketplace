@extends('layouts.admin')

@section('title', 'Manage Produk')

@section('content')

<div class="bg-primary shadow-sm rounded-xl border border-border overflow-hidden">

    {{-- ================== ALERT SUCCESS ================== --}}
    @if (session('success'))
    <div id="alertSuccess"
        class="flex items-center justify-between bg-green-500/20 text-green-700 border border-green-500 rounded-lg px-4 py-3 mb-4 animate-fade"
    >
        <span class="text-sm font-medium">
            {{ session('success') }}
        </span>

        <button onclick="document.getElementById('alertSuccess').classList.add('hidden')"
            class="ms-4 text-green-700 hover:text-green-900">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    @endif


    {{-- ================== ALERT ERROR ================== --}}
    @if (session('error'))
    <div id="alertError"
        class="flex items-center justify-between bg-red-500/20 text-red-600 border border-red-500 rounded-lg px-4 py-3 mb-4 animate-fade"
    >
        <span class="text-sm font-medium">
            {{ session('error') }}
        </span>

        <button onclick="document.getElementById('alertError').classList.add('hidden')"
            class="ms-4 text-red-600 hover:text-red-800">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    @endif


    {{-- ================= SEARCH + ADD ================= --}}
    <div class="p-4 flex items-center gap-4 justify-between">

        {{-- SEARCH --}}
        <div class="relative w-full max-w-md">
            <span class="absolute inset-y-0 left-3 flex items-center text-textPrimary/60">
                <i data-lucide="search" class="w-4 h-4"></i>
            </span>
            <input 
                type="text" 
                id="searchProduk"
                class="w-full ps-9 pe-3 py-2 bg-background border border-border rounded-lg text-sm focus:ring-accent focus:border-accent"
                placeholder="Cari produk..."
                onkeyup="filterProduk()"
            >
        </div>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">

            <thead class="bg-background border-y border-border">
                <tr>
                    <th class="px-6 py-3 font-medium">No</th>
                    <th class="px-6 py-3 font-medium">Gambar</th>
                    <th class="px-6 py-3 font-medium">Nama Produk</th>
                    <th class="px-6 py-3 font-medium">Harga</th>
                    <th class="px-6 py-3 font-medium">Stok</th>
                    <th class="px-6 py-3 font-medium">Kategori</th>
                    <th class="px-6 py-3 font-medium text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="produkTable">

                @php
                    $no = 1;
                @endphp

                @foreach($produks as $p)
                <tr class="bg-primary border-b border-border hover:bg-background transition">

                    <td class="px-6 py-4">{{ $no++ }}</td>

                    <td class="px-6 py-4">
                        @if ($p->Gambar->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach ($p->Gambar->take(4) as $g)
                                    <img src="{{ asset('storage/imageproduk/'.$g->path_gambar) }}"
                                        class="w-12 h-12 rounded object-cover border border-border">
                                @endforeach
                            </div>
                        @else
                            <span class="text-textSecondary">Tidak ada gambar</span>
                        @endif
                    </td>

                    <td class="px-6 py-4">{{ $p->nama_produk }}</td>

                    <td class="px-6 py-4">
                        Rp {{ number_format($p->harga_produk,0,',','.') }}
                    </td>

                    <td class="px-6 py-4">{{ $p->stok }}</td>

                    <td class="px-6 py-4">{{ $p->kategori->nama_katgori }}</td>

                    <td class="px-6 py-4 text-center">

                        <button onclick="openEditProduk({{ $p->id }})"
                            class="text-accent hover:underline mr-3">
                            Edit
                        </button>

                        <button onclick="openDeleteProduk({{ $p->id }})"
                            class="text-red-500 hover:underline">
                            Hapus
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>



{{-- ========================================================= --}}
{{-- ===================== MODAL ADD PRODUK ================== --}}
{{-- ========================================================= --}}

<div id="addProdukModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">
    <div class="relative p-4 w-full max-w-xl">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Tambah Produk</h3>
                <button onclick="closeAddProduk()" class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid gap-4">

                    <div>
                        <label class="text-sm font-medium">Nama Produk</label>
                        <input type="text" name="nama_produk"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Harga Produk</label>
                        <input type="number" name="harga_produk"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Stok</label>
                        <input type="number" name="stok"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kategori</label>
                        <select name="kategori_id"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_katgori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Deskripsi Produk</label>
                        <textarea name="deskripsi_produk"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm"
                            rows="3" required></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Gambar Produk</label>
                        <input type="file" name="gambar_produk[]" multiple
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                        <p class="text-xs text-textSecondary mt-1">Bisa upload lebih dari 1 gambar.</p>
                    </div>

                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" onclick="closeAddProduk()"
                        class="px-4 py-2 bg-background border border-border rounded-lg text-sm">
                        Tutup
                    </button>

                    <button class="px-4 py-2 bg-secondary text-background rounded-lg text-sm">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



{{-- ========================================================= --}}
{{-- ===================== MODAL EDIT PRODUK ================= --}}
{{-- ========================================================= --}}

@foreach($produks as $p)
<div id="editProdukModal{{ $p->id }}" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-xl">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Edit Produk</h3>
                <button onclick="closeEditProduk({{ $p->id }})" class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <form action="{{ route('produk.update') }}" method="POST">
                @csrf
                @method("PUT")

                <input type="hidden" name="id" value="{{ $p->id }}">

                <div class="grid gap-4">

                    <div>
                        <label class="text-sm font-medium">Nama Produk</label>
                        <input type="text" name="nama_produk"
                            value="{{ $p->nama_produk }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Harga Produk</label>
                        <input type="number" name="harga_produk"
                            value="{{ $p->harga_produk }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Stok</label>
                        <input type="number" name="stok"
                            value="{{ $p->stok }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kategori</label>
                        <select name="kategori_id"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ $k->id == $p->kategori_id ? 'selected' : '' }}>
                                    {{ $k->nama_katgori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Deskripsi Produk</label>
                        <textarea name="deskripsi_produk"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm"
                            rows="3">{{ $p->deskripsi_produk }}</textarea>
                    </div>

                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" onclick="closeEditProduk({{ $p->id }})"
                        class="px-4 py-2 bg-background border border-border rounded-lg text-sm">
                        Tutup
                    </button>

                    <button class="px-4 py-2 bg-secondary text-background rounded-lg text-sm">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endforeach



{{-- ========================================================= --}}
{{-- ===================== MODAL DELETE ======================= --}}
{{-- ========================================================= --}}

@foreach($produks as $p)
<div id="deleteProdukModal{{ $p->id }}" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-md">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6 text-center">

            <button onclick="closeDeleteProduk({{ $p->id }})"
                class="absolute top-3 right-3 text-textPrimary/60 hover:bg-background p-1.5 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <i data-lucide="trash-2" class="w-12 h-12 mx-auto mb-3 text-red-500"></i>

            <p class="text-textPrimary">
                Yakin ingin menghapus produk  
                <span class="font-semibold text-red-500">"{{ $p->nama_produk }}"</span> ?
            </p>

            <div class="flex justify-center gap-3 mt-6">
                <button onclick="closeDeleteProduk({{ $p->id }})"
                    class="px-4 py-2 bg-background border border-border rounded-lg text-sm">
                    Batal
                </button>

                <a href="{{ route('admin.produk.delete', $p->id) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                    Ya, hapus
                </a>
            </div>

        </div>
    </div>

</div>
@endforeach



{{-- ========================================================= --}}
{{-- ===================== JAVASCRIPT ========================= --}}
{{-- ========================================================= --}}
<script>

    // Auto close after 3 seconds
    setTimeout(() => {
        let s = document.getElementById('alertSuccess');
        let e = document.getElementById('alertError');

        if (s) s.classList.add('hidden');
        if (e) e.classList.add('hidden');
    }, 3000);

function filterProduk() {
    let search = document.getElementById('searchProduk').value.toLowerCase();
    let rows = document.querySelectorAll('#produkTable tr');

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
}

function openAddProduk() {
    document.getElementById('addProdukModal').classList.remove('hidden');
}
function closeAddProduk() {
    document.getElementById('addProdukModal').classList.add('hidden');
}

function openEditProduk(id) {
    document.getElementById('editProdukModal' + id).classList.remove('hidden');
}
function closeEditProduk(id) {
    document.getElementById('editProdukModal' + id).classList.add('hidden');
}

function openDeleteProduk(id) {
    document.getElementById('deleteProdukModal' + id).classList.remove('hidden');
}
function closeDeleteProduk(id) {
    document.getElementById('deleteProdukModal' + id).classList.add('hidden');
}

lucide.createIcons();

</script>

@endsection
