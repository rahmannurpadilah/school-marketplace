@extends('layouts.admin')

@section('title', 'Manage Kategori')

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
                id="searchKategori"
                class="w-full ps-9 pe-3 py-2 bg-background border border-border rounded-lg text-sm focus:ring-accent focus:border-accent"
                placeholder="Cari kategori..."
                onkeyup="filterKategori()"
            >
        </div>

        {{-- ADD KATEGORI --}}
        <button onclick="openAddKategori()"
            class="bg-secondary text-background px-4 py-2 rounded-lg text-sm hover:bg-secondary/90">
            + Tambah Kategori
        </button>

    </div>

    {{-- ================= TABLE ================= --}}
    <table class="w-full text-sm text-left">

        <thead class="bg-background border-y border-border">
            <tr>
                <th class="px-6 py-3 font-medium">No</th>
                <th class="px-6 py-3 font-medium">Nama Kategori</th>
                <th class="px-6 py-3 font-medium text-center">Aksi</th>
            </tr>
        </thead>

        <tbody id="kategoriTable">
            @php $no = 1; @endphp
            @foreach($kategori as $k)
            <tr class="bg-primary border-b border-border hover:bg-background transition">

                <td class="px-6 py-4">{{ $no++ }}</td>
                <td class="px-6 py-4">{{ $k->nama_kategori }}</td>

                <td class="px-6 py-4 text-center">

                    <button onclick="openEditKategori({{ $k->id }})"
                        class="text-accent hover:underline mr-3">
                        Edit
                    </button>

                    <button onclick="openDeleteKategori({{ $k->id }})"
                        class="text-red-500 hover:underline">
                        Hapus
                    </button>

                </td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>



{{-- ========================================================= --}}
{{-- ===================== MODAL ADD ========================== --}}
{{-- ========================================================= --}}

<div id="addKategoriModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">
    <div class="relative p-4 w-full max-w-lg">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Tambah Kategori</h3>
                <button onclick="closeAddKategori()" class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <label class="text-sm font-medium">Nama Kategori</label>
                <input type="text" name="nama_kategori"
                       class="bg-background border border-border rounded-lg w-full p-2.5 text-sm mt-1"
                       required>

                {{-- FOOTER --}}
                <div class="flex justify-end mt-6 gap-3">
                    <button type="button"
                        onclick="closeAddKategori()"
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
{{-- ===================== MODAL EDIT ======================== --}}
{{-- ========================================================= --}}

@foreach($kategori as $k)
<div id="editKategoriModal{{ $k->id }}" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">
    <div class="relative p-4 w-full max-w-lg">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Edit Kategori</h3>
                <button onclick="closeEditKategori({{ $k->id }})"
                    class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.kategori.update') }}" method="POST">
                @csrf
                @method("PUT")

                <input type="hidden" name="id" value="{{ $k->id }}">

                <label class="text-sm font-medium">Nama Kategori</label>
                <input type="text" name="nama_katgori"
                       value="{{ $k->nama_kategori }}"
                       class="bg-background border border-border rounded-lg w-full p-2.5 text-sm mt-1"
                       required>

                {{-- FOOTER --}}
                <div class="flex justify-end mt-6 gap-3">
                    <button type="button"
                        onclick="closeEditKategori({{ $k->id }})"
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
{{-- ===================== MODAL HAPUS ======================= --}}
{{-- ========================================================= --}}

@foreach($kategori as $k)
<div id="deleteKategoriModal{{ $k->id }}" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">
    <div class="relative p-4 w-full max-w-md">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6 text-center">

            <button onclick="closeDeleteKategori({{ $k->id }})"
                class="absolute top-3 right-3 text-textPrimary/60 hover:bg-background p-1.5 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <i data-lucide="trash-2" class="w-12 h-12 mx-auto mb-3 text-red-500"></i>

            <p class="text-textPrimary">
                Yakin ingin menghapus kategori  
                <span class="font-semibold text-red-500">"{{ $k->nama_kategori }}"</span> ?
            </p>

            <div class="flex justify-center gap-3 mt-6">
                <button onclick="closeDeleteKategori({{ $k->id }})"
                    class="px-4 py-2 bg-background border border-border rounded-lg text-sm">
                    Batal
                </button>

                <a href="{{ route('admin.kategori.delete', $k->id) }}"
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


function filterKategori() {
    let search = document.getElementById('searchKategori').value.toLowerCase();
    let rows = document.querySelectorAll('#kategoriTable tr');

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
}

function openAddKategori() {
    document.getElementById('addKategoriModal').classList.remove('hidden');
}
function closeAddKategori() {
    document.getElementById('addKategoriModal').classList.add('hidden');
}

function openEditKategori(id) {
    document.getElementById('editKategoriModal' + id).classList.remove('hidden');
}
function closeEditKategori(id) {
    document.getElementById('editKategoriModal' + id).classList.add('hidden');
}

function openDeleteKategori(id) {
    document.getElementById('deleteKategoriModal' + id).classList.remove('hidden');
}
function closeDeleteKategori(id) {
    document.getElementById('deleteKategoriModal' + id).classList.add('hidden');
}

lucide.createIcons();

</script>

@endsection
