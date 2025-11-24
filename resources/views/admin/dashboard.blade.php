@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">

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

    {{-- CARD USERS --}}
    <div class="bg-primary border border-border rounded-xl shadow-md p-6 flex items-center justify-between 
                hover:shadow-lg transition-all duration-300">
        
        <div>
            <h5 class="text-textSecondary font-semibold">Total Users</h5>
            <h2 class="text-3xl font-bold text-textPrimary mt-2">{{ $users }}</h2>
        </div>

        <div class="p-4 rounded-xl bg-secondary/10">
            <i data-lucide="users" class="w-10 h-10 text-secondary"></i>
        </div>
    </div>

    {{-- CARD TOKO --}}
    <div class="bg-primary border border-border rounded-xl shadow-md p-6 flex items-center justify-between 
                hover:shadow-lg transition-all duration-300">
        
        <div>
            <h5 class="text-textSecondary font-semibold">Total Toko</h5>
            <h2 class="text-3xl font-bold text-textPrimary mt-2">{{ $tokos }}</h2>
        </div>

        <div class="p-4 rounded-xl bg-secondary/10">
            <i data-lucide="store" class="w-10 h-10 text-secondary"></i>
        </div>
    </div>

    {{-- CARD PRODUK --}}
    <div class="bg-primary border border-border rounded-xl shadow-md p-6 flex items-center justify-between 
                hover:shadow-lg transition-all duration-300">
        
        <div>
            <h5 class="text-textSecondary font-semibold">Total Produk</h5>
            <h2 class="text-3xl font-bold text-textPrimary mt-2">{{ $produks }}</h2>
        </div>

        <div class="p-4 rounded-xl bg-secondary/10">
            <i data-lucide="package" class="w-10 h-10 text-secondary"></i>
        </div>
    </div>

</div>

    <script>
        // Auto close after 3 seconds
        setTimeout(() => {
            let s = document.getElementById('alertSuccess');
            let e = document.getElementById('alertError');

            if (s) s.classList.add('hidden');
            if (e) e.classList.add('hidden');
        }, 3000);
    </script>

@endsection
