@extends('admin.template')

@section('content')

<style>
    #userTable thead th {
        color: #000 !important;
        background-color: #f8f9fa !important;
        font-weight: bold;
    }
</style>

<div class="card">

    {{-- Alert sukses --}}
    @if (session('succsess'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('succsess') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data User</h5>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            + Add Member
        </button>
    </div>

    <div class="card-body">

        <table class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->kontak }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->role }}</td>
                    <td>

                        {{-- BUTTON OPEN MODAL EDIT --}}
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $u->id }}">
                            Edit
                        </button>

                        <a href="{{ route('admin.deleteMember', $u->id) }}"
                           class="btn btn-danger"
                           onclick="return confirm('Yakin ingin menghapus?')">
                           Hapus
                        </a>

                    </td>
                </tr>


                {{-- ========================
                    MODAL EDIT PER-USER
                ========================= --}}
                <div class="modal fade" id="editModal{{ $u->id }}">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5>Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <form action="{{ route('admin.updateMember') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $u->id }}">

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ $u->name }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Kontak</label>
                                <input type="text" name="kontak" value="{{ $u->kontak }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" value="{{ $u->username }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password (isi ulang)</label>
                                <input type="password" name="password" value="{{ $u->password }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="member" {{ $u->role == 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary">Update</button>
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


{{-- ========================
    MODAL ADD MEMBER
========================= --}}
<div class="modal fade" id="addMemberModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.addmember') }}" method="POST">
        @csrf

        <div class="modal-body">

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kontak</label>
                <input type="text" name="kontak" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
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
