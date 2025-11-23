@extends('layouts.global')

@section('title', 'Register')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-background">

    <div
        class="w-full max-w-md p-8 rounded-2xl shadow-xl border"
        style="
            background-color: var(--primary);
            border-color: var(--secondary);
        "
    >
        <h1 class="text-3xl font-bold mb-6 text-center text-text-primary">
            Register Akun
        </h1>

        @if(session('error'))
            <div id="alertError"
                class="relative mb-4 p-3 rounded-lg text-red-600 border border-red-300 bg-red-100 text-center transition-opacity">

                {{ session('error') }}

                <button onclick="closeAlert('alertError')"
                    class="absolute right-3 top-3 text-red-700 hover:text-red-900">
                    <i data-lucide="x"></i>
                </button>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 font-medium text-text-primary">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    class="text-background w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <div>
                <label class="block mb-2 font-medium text-text-primary">Kontak</label>
                <input
                    type="text"
                    name="kontak"
                    class="text-background w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent"
                    placeholder="Masukkan kontak"
                    required
                >
            </div>

            <div>
                <label class="block mb-2 font-medium text-text-primary">Username</label>
                <input
                    type="text"
                    name="username"
                    class="text-background w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            <div>
                <label class="block mb-2 font-medium text-text-primary">Password</label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="text-background w-full border border-border rounded-lg px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-accent"
                        placeholder="Masukkan password"
                        required
                    >

                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-text-secondary"
                    >
                        <i data-lucide="eye" id="iconEye"></i>
                        <i data-lucide="eye-off" id="iconEyeOff" class="hidden"></i>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-secondary text-background py-3 rounded-lg font-semibold hover:bg-secondary/90 transition-colors"
            >
                Daftar
            </button>

            <p class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-text-secondary hover:underline">
                    Sudah punya akun? Login
                </a>
            </p>

        </form>
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const eye = document.getElementById("iconEye");
        const eyeOff = document.getElementById("iconEyeOff");

        if (input.type === "password") {
            input.type = "text";
            eye.classList.add("hidden");
            eyeOff.classList.remove("hidden");
        } else {
            input.type = "password";
            eye.classList.remove("hidden");
            eyeOff.classList.add("hidden");
        }
    }

    function closeAlert(id) {
        const alertBox = document.getElementById(id);
        alertBox.classList.add("opacity-0");
        setTimeout(() => alertBox.style.display = "none", 200);
    }

    lucide.createIcons();
</script>

@endsection
