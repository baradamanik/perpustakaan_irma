@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Peminjaman</h3>
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
                    <form method="post" action="{{ route($url, $pinjam->peminjamanid ?? '') }}">
                        @csrf
                        @if(isset($pinjam))
                            @method('put')
                        @endif
                        <div class="form-group">
                            <label for="bukuid">Member</label>
                            <select class="form-control @error('id') {{'is-invalid'}} @enderror" name="id">
                                <option value="">Pilih Member</option>
                                @foreach ($user as $member)
                                    <option value="{{ $member->id }}" {{ (old('id') ?? $pinjam->id ?? '') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                            @error('id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="buku">Buku</label>
                            <select class="form-control @error('bukuid') {{'is-invalid'}} @enderror" name="bukuid">
                                <option value="">Pilih Buku</option>
                                @foreach ($bukubuku as $buku)
                                    <option value="{{ $buku->bukuid }}" {{ (old('bukuid') ?? $pinjam->bukuid ?? '') == $buku->bukuid ? 'selected' : '' }}>{{ $buku->title }}</option>
                                @endforeach
                            </select>
                            @error('bukuid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggalpeminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" name="tanggalpeminjaman" value="{{ old('tanggal_peminjaman') ?? ($pinjam->tanggalpeminjaman ?? '') }}">
                            @error('tanggalpeminjaman')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggalpengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="tanggalpengembalian" value="{{ old('tanggalpengembalian') ?? ($pinjam->tanggalpengembalian ?? '') }}">
                            @error('tanggalpengembalian')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                        <label for="status_peminjaman">Status Pengembalian</label>
                        <select class="form-control" name="status_peminjaman">
                            <option value="Belum Dikembalikan">Belum Dikembalikan</option>
                            <option value="Belum Dikembalikan" {{ (old('status_peminjaman') ?? ($pinjam->status_peminjaman ?? '')) == "Belum Dikembalikan" ? 'selected' : '' }}>Belum Dikembalikan</option>
                            <option value="Sudah Dikembalikan" {{ (old('status_peminjaman') ?? ($pinjam->status_peminjaman ?? '')) == "Sudah Dikembalikan" ? 'selected' : '' }}>Sudah Dikembalikan</option>
                            <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                        </select>
                        @error('status_peminjaman')
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
    @if(isset($pinjam))
            <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus data peminjaman dari member ini?</p>
                    </div>

                    <div class="modal-footer">
                        <form action="{{ route('dashboard.peminjaman.delete', $pinjam->peminjamanid) }}" method="post">
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