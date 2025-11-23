@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">

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

@endsection
