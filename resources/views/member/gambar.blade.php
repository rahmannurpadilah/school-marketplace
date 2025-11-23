@extends('membe.tamplate')

@section('content')

<div class="container mt-4">

    <h3>Daftar Semua Gambar Produk Toko Anda</h3>
    <hr>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- JIKA TIDAK ADA GAMBAR --}}
    @if($gambars->count() == 0)
        <div class="alert alert-info">
            Belum ada gambar yang diupload.
        </div>
    @endif

    <div class="table-responsive mt-3">
        <table id="gambarTable" class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th width="120">Gambar</th>
                        <th>Nama Produk</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($gambars as $gmbr)
                    <tr>
                        <td>{{ $gmbr->id }}</td>

                        <td>
                            <img src="{{ asset('storage/imageproduk/' . $gmbr->path_gambar) }}"
                                 style="width: 100px; height: 90px; object-fit: cover; border-radius: 5px;">
                        </td>

                        <td>
                            <strong>{{ $gmbr->produk->nama_produk }}</strong>
                        </td>

                        <td class="text-center">

                            {{-- HAPUS --}}
                            <a href="{{ route('member.gambar.delete', $gmbr->id) }}"
                               onclick="return confirm('Hapus gambar ini?')"
                               class="btn btn-danger btn-sm mb-1">
                                Hapus
                            </a>

                            {{-- EDIT --}}
                            <button class="btn btn-warning btn-sm mb-1"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $gmbr->id }}">
                                Edit
                            </button>
                        </td>
                    </tr>

                    {{-- ===== MODAL EDIT GAMBAR ===== --}}
                    <div class="modal fade" id="editModal{{ $gmbr->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <form action="{{ route('member.gambar.update', $gmbr->id) }}"
                                method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Gambar Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <p>Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/imageproduk/'.$gmbr->path_gambar) }}"
                                     class="img-fluid rounded mb-3">

                                <div class="mb-3">
                                    <label>Upload Gambar Baru</label>
                                    <input type="file" name="path_gambar" class="form-control" required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
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
<script>
    $(document).ready(function () {
        $('#gambarTable').DataTable({
            responsive: true
        });
    });
</script>

@endsection
