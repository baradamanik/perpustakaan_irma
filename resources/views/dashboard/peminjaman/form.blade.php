@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Kategori Buku Relasi</h3>
                </div>
                <div class="col-4 text-right">
                <button class="btn btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                    <!-- Tambahkan konten di sini sesuai kebutuhan -->
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form method="post" action="{{ route($url, $kategoriBukuRelasi->kategoribukuid ?? '') }}">
                        @csrf
                        @if(isset($kategoriBukuRelasi))
                            @method('put')
                        @endif
                        <div class="form-group">
                            <label for="bukuid">Buku</label>
                            <select class="form-control @error('bukuid') {{'is-invalid'}} @enderror" name="bukuid">
                                <option value="">Pilih Buku</option>
                                @foreach ($bukubuku as $buku)
                                    <option value="{{ $buku->bukuid }}" {{ (old('bukuid') ?? $kategoriBukuRelasi->bukuid ?? '') == $buku->bukuid ? 'selected' : '' }}>{{ $buku->title }}</option>
                                @endforeach
                            </select>
                            @error('bukuid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategoriid">Kategori</label>
                            <select class="form-control @error('kategoriid') {{'is-invalid'}} @enderror" name="kategoriid">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoriBuku as $kategori)
                                    <option value="{{ $kategori->kategoriid }}" {{ (old('kategoriid') ?? $kategoriBukuRelasi->kategoriid ?? '') == $kategori->kategoriid ? 'selected' : '' }}>{{ $kategori->namakategori }}</option>
                                @endforeach
                            </select>
                            @error('kategoriid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <button type="button" onclick="window.history.back()" class="btn btn-sm btn-secondary button-spacing">Cancel</button>
                            <button type="submit" class="btn btn-success btn-sm">{{$button}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($kategoriBukuRelasi))
            <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus kategori buku ini?</p>
                    </div>

                    <div class="modal-footer">
                        <form action="{{ route('dashboard.kategoribukurelasi.delete', $kategoriBukuRelasi->kategoribukuid) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
    @endif
</div>

@endsection