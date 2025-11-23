@extends('user.template')
@section('content')

<style>
    .preview-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #ddd;
        display: none;
    }
</style>

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="m-0">Buat Toko Baru</h4>
                </div>

                <div class="card-body">

                    {{-- Alert validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM CREATE TOKO --}}
                    <form action="{{ route('user.toko.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Toko --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control" required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" rows="4" class="form-control" required></textarea>
                        </div>

                        {{-- Foto Toko --}}
                        <div class="mb-3">
                            <label class="form-label">Foto Toko</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                            <img id="preview" class="preview-img mt-3">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Buat Toko
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- PREVIEW GAMBAR --}}
<script>
    function previewImage(event) {
        const img = document.getElementById('preview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
</script>

@endsection
