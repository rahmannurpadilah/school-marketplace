@extends('membe.tamplate')

@section('content')

<style>
    #produkTable thead th {
        color: #000 !important;
        background-color: #f8f9fa !important;
        font-weight: bold;
    }
</style>

@php
    $toko = Auth::user()->Toko;
@endphp

<div class="card">

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Produk</h5>
        @if ($toko && $toko->status != 'pending' && $toko->status != 'ditolak')
        {{-- Tombol membuka modal tambah --}}
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProdukModal">
            + Tambah Produk
        </button>
        @endif
    </div>

    <div class="card-body table-responsive">
        <table id="produkTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($produks as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>
                        @if ($p->Gambar->count() > 0)
                            @foreach ($p->Gambar->take(4) as $g)
                                <img src="{{ asset('storage/imageproduk/'.$g->path_gambar) }}"
                                     width="60" height="60"
                                     class="rounded me-1 mb-1">
                            @endforeach
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>{{ $p->nama_produk }}</td>
                    <td>Rp {{ number_format($p->harga_produk,0,',','.') }}</td>
                    <td>{{ $p->stok }}</td>
                    <td>{{ $p->kategori->nama_katgori }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProdukModal{{ $p->id }}">
                            Edit
                        </button>

                        {{-- Tombol Hapus --}}
                        <a href="{{ route('produk.delete', $p->id) }}"
                           class="btn btn-danger"
                           onclick="return confirm('Yakin ingin menghapus produk ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>

                {{-- MODAL EDIT PER PRODUK --}}
                <div class="modal fade" id="editProdukModal{{ $p->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <form action="{{ route('produk.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $p->id }}">

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk"
                                       class="form-control"
                                       value="{{ $p->nama_produk }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Harga Produk</label>
                                <input type="number" name="harga_produk"
                                       class="form-control"
                                       value="{{ $p->harga_produk }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok"
                                       class="form-control"
                                       value="{{ $p->stok }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-control" required>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $k->id == $p->kategori_id ? 'selected' : '' }}>
                                            {{ $k->nama_katgori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Deskripsi Produk</label>
                                <textarea name="deskripsi_produk"
                                          class="form-control"
                                          rows="3" required>{{ $p->deskripsi_produk }}</textarea>
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

{{-- ================= MODAL ADD PRODUK ================= --}}
<div class="modal fade" id="addProdukModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">

            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Harga Produk</label>
                <input type="number" name="harga_produk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_katgori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Deskripsi Produk</label>
                <textarea name="deskripsi_produk" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label>Gambar Produk</label>
                <input type="file" name="gambar_produk[]" class="form-control" multiple required>
                <small class="text-muted">Bisa upload lebih dari 1 gambar.</small>
            </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection
