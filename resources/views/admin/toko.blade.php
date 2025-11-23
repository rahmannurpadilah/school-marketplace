@extends('admin.template')

@section('content')

<div class="card">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="card-header d-flex justify-content-between">
        <h5>Data Toko</h5>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            + Add Toko
        </button>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Toko</th>
                    <th>Owner</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tokos as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->nama_toko }}</td>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->kontak_toko }}</td>
                    <td>{{ $t->alamat }}</td>
                    <td>{{ $t->status }}</td>
                    <td>

                        {{-- BUTTON EDIT --}}
                        <button class="btn btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $t->id }}">
                            Edit
                        </button>

                        <a href="{{ route('admin.toko.delete', $t->id) }}"
                           onclick="return confirm('Hapus toko ini?')"
                           class="btn btn-danger">Hapus</a>

                        <form action="{{ route('member.approve.toko', $t->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-info">Approve</button>
                        </form>

                    </td>
                </tr>

                {{-- ===========================
                    MODAL EDIT PER DATA
                ============================ --}}
                <div class="modal fade" id="editModal{{ $t->id }}">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5>Edit Toko</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <form action="{{ route('admin.toko.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $t->id }}">

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Nama Toko</label>
                                <input type="text" name="nama_toko" class="form-control"
                                       value="{{ $t->nama_toko }}">
                            </div>

                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control">{{ $t->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Owner</label>
                                <select name="user_id" class="form-control">
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ $u->id == $t->user_id ? 'selected' : '' }}>
                                            {{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Kontak Toko</label>
                                <input type="text" name="kontak_toko" class="form-control"
                                       value="{{ $t->kontak_toko }}">
                            </div>

                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control">{{ $t->alamat }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Gambar (optional)</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>

                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button class="btn btn-primary">Update</button>
                        </div>

                      </form>

                    </div>
                  </div>
                </div>

                @endforeach
            </tbody>
        </table>

    </div>
</div>


{{-- ===========================
    MODAL ADD GLOBAL
=========================== --}}
<div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Tambah Toko</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.toko.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">

            <div class="mb-3">
                <label>Nama Toko</label>
                <input type="text" name="nama_toko" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Owner</label>
                <select name="user_id" class="form-control">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Kontak</label>
                <input type="text" name="kontak_toko" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button class="btn btn-primary">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endsection
