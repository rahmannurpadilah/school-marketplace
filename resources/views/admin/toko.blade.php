@extends('layouts.admin')

@section('title', 'Manage Toko')

@section('content')

<div class="bg-primary shadow-sm rounded-xl border border-border overflow-hidden">

    {{-- ================== ALERT SUCCESS ================== --}}
    @if (session('success'))
    <div id="alertSuccess"
         class="flex items-center justify-between bg-green-500/20 text-green-700 border border-green-500
                rounded-lg px-4 py-3 mb-4 animate-fade">
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
         class="flex items-center justify-between bg-red-500/20 text-red-600 border border-red-500
                rounded-lg px-4 py-3 mb-4 animate-fade">
        <span class="text-sm font-medium">
            {{ session('error') }}
        </span>

        <button onclick="document.getElementById('alertError').classList.add('hidden')"
            class="ms-4 text-red-600 hover:text-red-800">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    @endif


    {{-- ==================== HEADER ==================== --}}
    <div class="p-4 flex items-center justify-between">

        <h3 class="text-lg font-semibold text-textPrimary">Data Toko</h3>

        <div class="flex gap-4 items-center">

            {{-- FILTER STATUS --}}
            <div class="relative">
                <button onclick="toggleStatusFilter()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-background border border-border rounded-lg hover:bg-surface text-sm">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    Filter Status
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </button>
                <div id="statusFilterDropdown"
                    class="hidden absolute right-0 mt-2 w-40 bg-primary border border-border rounded-lg shadow-lg z-20">

                    <button onclick="setStatusFilter('all')" class="block w-full text-left px-4 py-2 hover:bg-surface text-sm">
                        Semua Status
                    </button>

                    @php
                        $uniqueStatus = $tokos->pluck('status')->unique();
                    @endphp

                    @foreach ($uniqueStatus as $st)
                        <button onclick="setStatusFilter('{{ $st }}')"
                            class="block w-full text-left px-4 py-2 hover:bg-surface text-sm">
                            {{ $st == 0 ? 'Pending' : ($st == 1 ? 'Active' : ($st == 2 ? 'Ditolak' : $st)) }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- ADD BUTTON --}}
            <button onclick="openAddModal()"
                class="bg-secondary text-background px-4 py-2 rounded-lg text-sm hover:bg-secondary/90">
                + Tambah Toko
            </button>

        </div>
    </div>

    {{-- ==================== TABLE ==================== --}}
    <table class="w-full text-sm text-left">

        <thead class="bg-background border-y border-border">
            <tr>
                <th class="px-6 py-3 font-medium">No</th>
                <th class="px-6 py-3 font-medium">Nama Toko</th>
                <th class="px-6 py-3 font-medium">Owner</th>
                <th class="px-6 py-3 font-medium">Kontak</th>
                <th class="px-6 py-3 font-medium">Alamat</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium text-center">Aksi</th>
            </tr>
        </thead>

        <tbody id="tokoTable">

            @php $no = 1; @endphp

            @foreach($tokos as $t)
            <tr class="bg-primary border-b border-border hover:bg-background transition"
                data-status="{{ $t->status }}">

                <td class="px-6 py-4">{{ $no++ }}</td>
                <td class="px-6 py-4">{{ $t->nama_toko }}</td>
                <td class="px-6 py-4">{{ $t->user->name }}</td>
                <td class="px-6 py-4">{{ $t->kontak_toko }}</td>
                <td class="px-6 py-4">{{ $t->alamat }}</td>

                <td class="px-6 py-4 font-semibold text-textSecondary">
                    {{ $t->status }}
                </td>

                <td class="px-6 py-4 text-center flex items-center justify-center gap-3">

                    <button onclick="openEditModal({{ $t->id }})"
                        class="text-accent hover:underline">
                        Edit
                    </button>

                    <button onclick="openDeleteModal({{ $t->id }})"
                        class="text-red-500 hover:underline">
                        Hapus
                    </button>

                    @if ($t->status == 'pending')
                        <form action="{{ route('member.setujui.toko', $t->id) }}" method="POST">
                            @csrf
                            <button class="text-blue-400 hover:underline">
                                Setujui
                            </button>
                        </form>
                        <form action="{{ route('member.tolak.toko', $t->id) }}" method="POST">
                            @csrf
                            <button class="text-red-400 hover:underline">
                                Tolak
                            </button>
                        </form>
                    @endif

                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>



{{-- =============== MODAL ADD ================= --}}
<div id="addModal"
    class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-2xl">

        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            <div class="flex justify-between items-center pb-3 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Tambah Toko</h3>

                <button onclick="closeAddModal()" class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.toko.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid gap-4">

                    <div>
                        <label class="text-sm font-medium">Nama Toko</label>
                        <input type="text" name="nama_toko"
                               class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Deskripsi</label>
                        <textarea name="deskripsi"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Owner</label>
                        <select name="user_id"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kontak Toko</label>
                        <input type="text" name="kontak_toko"
                               class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Alamat</label>
                        <textarea name="alamat"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Gambar</label>
                        <input type="file" name="gambar"
                               class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <button onclick="closeAddModal()" type="button"
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




{{-- =============== MODAL EDIT (PER DATA) ================= --}}
@foreach($tokos as $t)
<div id="editModal{{ $t->id }}"
    class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-2xl">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Edit Toko</h3>

                <button onclick="closeEditModal({{ $t->id }})"
                    class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.toko.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $t->id }}">

                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium">Nama Toko</label>
                        <input type="text" name="nama_toko" value="{{ $t->nama_toko }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium">Deskripsi</label>
                        <textarea name="deskripsi"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm"
                        >{{ $t->deskripsi }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Owner</label>
                        <select name="user_id"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ $u->id == $t->user_id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kontak Toko</label>
                        <input type="text" name="kontak_toko" value="{{ $t->kontak_toko }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium">Alamat</label>
                        <textarea name="alamat"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm"
                        >{{ $t->alamat }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium">Gambar (opsional)</label>
                        <input type="file" name="gambar"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <button onclick="closeEditModal({{ $t->id }})" type="button"
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





{{-- =============== MODAL DELETE ================= --}}
@foreach($tokos as $t)
<div id="deleteModal{{ $t->id }}"
    class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-md">

        <div class="relative bg-primary rounded-lg shadow border border-border p-6 text-center">

            <button onclick="closeDeleteModal({{ $t->id }})"
                class="absolute top-3 right-3 text-textPrimary/60 hover:bg-background p-1.5 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <i data-lucide="trash-2" class="w-12 h-12 mx-auto text-red-500 mb-3"></i>

            <p class="text-textPrimary">
                Yakin ingin menghapus toko  
                <span class="font-semibold text-red-500">"{{ $t->nama_toko }}"</span> ?
            </p>

            <div class="flex justify-center gap-3 mt-6">

                <button onclick="closeDeleteModal({{ $t->id }})"
                    class="px-4 py-2 bg-background border border-border rounded-lg text-sm">
                    Batal
                </button>

                <a href="{{ route('admin.toko.delete', $t->id) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                    Ya, hapus
                </a>

            </div>

        </div>

    </div>

</div>
@endforeach





{{-- ==================== JAVASCRIPT ========================= --}}
<script>

setTimeout(() => {
    let s = document.getElementById('alertSuccess');
    let e = document.getElementById('alertError');

    if (s) s.classList.add('hidden');
    if (e) e.classList.add('hidden');
}, 3000);


/* FILTER STATUS */
function toggleStatusFilter() {
    document.getElementById('statusFilterDropdown').classList.toggle('hidden');
}

function setStatusFilter(status) {
    window.currentStatus = status;
    filterStatus();
    toggleStatusFilter();
}

function filterStatus() {
    let rows = document.querySelectorAll('#tokoTable tr');
    let selected = window.currentStatus || 'all';

    rows.forEach(row => {
        let st = row.getAttribute('data-status');

        row.style.display = (selected === 'all' || st === selected)
            ? ''
            : 'none';
    });
}



function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}
function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function openEditModal(id) {
    document.getElementById('editModal' + id).classList.remove('hidden');
}
function closeEditModal(id) {
    document.getElementById('editModal' + id).classList.add('hidden');
}

function openDeleteModal(id) {
    document.getElementById('deleteModal' + id).classList.remove('hidden');
}
function closeDeleteModal(id) {
    document.getElementById('deleteModal' + id).classList.add('hidden');
}

lucide.createIcons();

</script>

@endsection
