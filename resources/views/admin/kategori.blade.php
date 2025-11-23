@extends('admin.template')
@section('content')

<div class="card">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-header d-flex justify-content-between">
        <h5>Data Kategori</h5>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
            + Add Kategori
        </button>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($kategori as $k)
                <tr>
                    <td>{{ $k->id }}</td>
                    <td>{{ $k->nama_katgori }}</td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $k->id) }}" class="btn btn-warning">
                            Edit
                        </a>

                        <a href="{{ route('admin.kategori.delete', $k->id) }}"
                           onclick="return confirm('Yakin ingin hapus?')"
                           class="btn btn-danger">
                           Hapus
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>



{{-- ------------------ MODAL ADD ------------------ --}}
<div class="modal fade" id="addKategoriModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>



{{-- ------------------ MODAL EDIT (AKTIF JIKA $kategoriEdit ADA) ------------------ --}}
@if(isset($kategoriEdit))
<script>

</script>

<div class="modal fade show" id="editKategoriModal" tabindex="-1" style="display:block; background:rgba(0,0,0,0.4)">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.kategori.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $kategoriEdit->id }}">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <a href="{{ route('admin.kategori') }}" class="btn-close"></a>
                </div>

                <div class="modal-body">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_katgori"
                           value="{{ $kategoriEdit->nama_kategori }}"
                           class="form-control" required>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('admin.kategori') }}" class="btn btn-secondary">Tutup</a>
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endif

@endsection
