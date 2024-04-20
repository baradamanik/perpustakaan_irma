@extends('layouts.dashboard')

@section('content')
    <div class="mb-2">
        @if($level != 3)
            <a href="{{ route('dashboard.peminjaman.create') }}" class="btn btn-primary">+ Peminjaman</a>
        @endif
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success">
        <strong>{{session()->get('message')}}</strong>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Peminjaman</h3>
                </div>
                <div class="col-4">
                    <form method="get" action="{{ route('dashboard.peminjaman') }}">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="q" value="{{ $request['q'] ?? '' }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($peminjaman->total())
                <table class="table table-bordered table-striped table-hover">
                    <thead>    
                        <tr>
                            <th>No</th>
                            <th>Member</th>
                            <th>Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status Peminjaman</th>
                            <th>Aksi</th> <!-- Tambahkan kolom untuk tombol Kembalikan -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $pinjam)
                            <tr>
                                <td>{{ ($peminjaman->currentPage() -1 ) * $peminjaman->perPage() + $loop->iteration }}</td>
                                <td>{{ $pinjam->user->name }}</td>
                                <td>{{ $pinjam->bukuid }} - {{ optional($pinjam->bukubuku)->title }}</td>
                                <td>{{ $pinjam->tanggalpeminjaman }}</td>
                                <td>{{ $pinjam->tanggalpengembalian }}</td>
                                <td>{{ $pinjam->status_peminjaman }}</td>
                                <td>
                                    @if($level != 3)
                                    <a href="{{ route('dashboard.peminjaman.edit', $pinjam->peminjamanid) }}" class="btn btn-success btn-sm">Edit</a>  &nbsp;
                                    @endif
                                    <a href="{{ route('dashboard.ulasanbuku', $pinjam->bukuid) }}" class="btn btn-warning btn-sm">Rate</a>  &nbsp;
                                    @if($pinjam->status_peminjaman == 'Belum Dikembalikan')
                                    <a href="{{ route('dashboard.books.baca', $pinjam->bukuid) }}" class="btn btn-success btn-sm" target="_blank">Baca</a>&nbsp;
                                        <button class="btn btn-warning btn-sm" onclick="return confirmKembalikan({{ $pinjam->peminjamanid }})">Kembalikan</button>
                                        
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $peminjaman->links() }}
            @else
                <h5 class="text-center p-3">Belum ada data Peminjaman</h5>
            @endif
        </div>
    </div>
@endsection
<script>
    function confirmKembalikan(id) {
        // Tampilkan dialog konfirmasi
        var confirmation = confirm('Apakah Anda yakin akan mengembalikan buku ini?');
        
        // Jika pengguna menekan OK
        if (confirmation) {
            // Redirect ke rute pengembalian
            window.location.href = "{{ route('dashboard.peminjaman.kembalikan', ['id' => ':id']) }}".replace(':id', id);
        }
    }
</script>


