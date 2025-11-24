@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')

{{-- ==================== SEARCH + FILTER ==================== --}}
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


    <div class="p-4 flex items-center gap-4 justify-between">
        
        {{-- SEARCH --}}
        <div class="relative w-full max-w-md">
            <span class="absolute inset-y-0 left-3 flex items-center text-textPrimary/60">
                <i data-lucide="search" class="w-4 h-4"></i>
            </span>
            <input 
                type="text" 
                id="searchInput"
                class="w-full ps-9 pe-3 py-2 bg-background border border-border rounded-lg text-sm focus:ring-accent focus:border-accent"
                placeholder="Cari user..."
                onkeyup="filterTable()"
            >
        </div>

        {{-- FILTER + ADD --}}
        <div class="flex gap-4 items-center">

            {{-- FILTER ROLE --}}
            <div class="relative">
                <button onclick="toggleFilter()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-background border border-border rounded-lg hover:bg-surface text-sm">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    Filter Role
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </button>

                <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-40 bg-primary border border-border rounded-lg shadow-lg z-20">
                    <button onclick="setRoleFilter('all')" class="block w-full text-left px-4 py-2 hover:bg-surface text-sm">
                        Semua Role
                    </button>

                    @php $roles = $users->pluck('role')->unique(); @endphp
                    @foreach($roles as $r)
                        <button onclick="setRoleFilter('{{ strtolower($r) }}')" 
                                class="block w-full text-left px-4 py-2 hover:bg-surface text-sm capitalize">
                            {{ $r }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- ADD USER BUTTON --}}
            <button onclick="openAddModal()"
                class="bg-secondary text-background px-4 py-2 rounded-lg text-sm hover:bg-secondary/90">
                + Tambah User
            </button>

        </div>
    </div>

    {{-- ==================== TABLE ==================== --}}
    <table class="w-full text-sm text-left">

        <thead class="bg-background border-y border-border">
            <tr>
                <th class="px-6 py-3 font-medium">No</th>
                <th class="px-6 py-3 font-medium">Nama</th>
                <th class="px-6 py-3 font-medium">Kontak</th>
                <th class="px-6 py-3 font-medium">Username</th>
                <th class="px-6 py-3 font-medium">Role</th>
                <th class="px-6 py-3 font-medium text-center">Aksi</th>
            </tr>
        </thead>

        <tbody id="userTable">
            @php
                $no = 1;
            @endphp

            @foreach($users as $u)
            <tr class="bg-primary border-b border-border hover:bg-background transition">

                <td class="px-6 py-4">{{ $no++ }}</td>
                <td class="px-6 py-4">{{ $u->name }}</td>
                <td class="px-6 py-4">{{ $u->kontak }}</td>
                <td class="px-6 py-4">{{ $u->username }}</td>
                <td class="px-6 py-4 font-semibold text-textSecondary">{{ $u->role }}</td>

                <td class="px-6 py-4 text-center">

                    <button onclick="openEditModal({{ $u->id }})"
                        class="text-accent hover:underline mr-3">
                        Edit
                    </button>

                    <button onclick="openDeleteModal({{ $u->id }})"
                        class="text-red-500 hover:underline">
                        Hapus
                    </button>

                </td>

            </tr>
            @endforeach

        </tbody>

    </table>
</div>



{{-- ================================================================== --}}
{{-- ==================== MODAL ADD USER ============================== --}}
{{-- ================================================================== --}}

<div id="addModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-2xl">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Tambah User</h3>

                <button onclick="closeAddModal()" type="button"
                    class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- BODY --}}
            <form action="{{ route('admin.addmember') }}" method="POST">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">

                    <div>
                        <label class="text-sm font-medium">Nama</label>
                        <input type="text" name="name"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kontak</label>
                        <input type="text" name="kontak"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Username</label>
                        <input type="text" name="username"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                </div>

                {{-- FOOTER --}}
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



{{-- ================================================================== --}}
{{-- ==================== MODAL EDIT USER ============================= --}}
{{-- ================================================================== --}}

@foreach($users as $u)
<div id="editModal{{ $u->id }}" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-2xl">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-border">
                <h3 class="text-lg font-semibold text-textPrimary">Edit User</h3>
                <button onclick="closeEditModal({{ $u->id }})"
                    class="text-textPrimary/60 hover:bg-background p-2 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- BODY --}}
            <form action="{{ route('admin.updateMember') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $u->id }}">

                <div class="grid gap-4 sm:grid-cols-2">

                    <div>
                        <label class="text-sm font-medium">Nama</label>
                        <input type="text" name="name" value="{{ $u->name }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kontak</label>
                        <input type="text" name="kontak" value="{{ $u->kontak }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Username</label>
                        <input type="text" name="username" value="{{ $u->username }}"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password" value="" placeholder="Isi jika mau ubah password"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium">Role</label>
                        <select name="role"
                            class="bg-background border border-border rounded-lg w-full p-2.5 text-sm">
                            <option value="member" {{ $u->role == 'member' ? 'selected' : '' }}>Member</option>
                            <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end mt-6 gap-3">
                    <button onclick="closeEditModal({{ $u->id }})" type="button"
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




{{-- ================================================================== --}}
{{-- ==================== MODAL DELETE USER =========================== --}}
{{-- ================================================================== --}}

@foreach($users as $u)
<div id="deleteModal{{ $u->id }}" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center">

    <div class="relative p-4 w-full max-w-md">
        <div class="relative bg-primary rounded-lg shadow border border-border p-6 text-center">

            {{-- CLOSE --}}
            <button onclick="closeDeleteModal({{ $u->id }})"
                class="absolute top-3 right-3 text-textPrimary/60 hover:bg-background p-1.5 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            {{-- ICON --}}
            <i data-lucide="trash-2" class="w-12 h-12 mx-auto mb-3 text-red-500"></i>

            {{-- MESSAGE --}}
            <p class="text-textPrimary">
                Yakin ingin menghapus user  
                <span class="font-semibold text-red-500">"{{ $u->name }}"</span> ?
            </p>

            {{-- BUTTONS --}}
            <div class="flex justify-center gap-3 mt-6">

                <button onclick="closeDeleteModal({{ $u->id }})"
                    class="px-4 py-2 bg-background border border-border rounded-lg text-sm">
                    Batal
                </button>

                <a href="{{ route('admin.deleteMember', $u->id) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                    Ya, hapus
                </a>

            </div>

        </div>
    </div>

</div>
@endforeach



{{-- ================================================================== --}}
{{-- ==================== JAVASCRIPT ================================ --}}
{{-- ================================================================== --}}

<script>

    // Auto close after 3 seconds
    setTimeout(() => {
        let s = document.getElementById('alertSuccess');
        let e = document.getElementById('alertError');

        if (s) s.classList.add('hidden');
        if (e) e.classList.add('hidden');
    }, 3000);

function toggleFilter() {
    document.getElementById('filterDropdown').classList.toggle('hidden');
}

function setRoleFilter(role) {
    window.currentRoleFilter = role;
    filterTable();
    toggleFilter();
}

function filterTable() {
    let search = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.querySelectorAll('#userTable tr');
    let roleFilter = window.currentRoleFilter || 'all';

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        let role = row.children[4].innerText.toLowerCase();

        let matchSearch = text.includes(search);
        let matchRole = roleFilter === 'all' || role === roleFilter;

        row.style.display = (matchSearch && matchRole) ? '' : 'none';
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
