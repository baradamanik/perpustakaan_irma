@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Buku</h3>
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
                    <form method="post" action="{{ route($url, $buku->bukuid ?? '') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($buku))
                            @method('put')
                        @endif
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') {{'is-invalid'}} @enderror" name="title" value="{{old('title') ?? $buku->title ?? ''}}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control @error('penulis') {{'is-invalid'}} @enderror" name="penulis" value="{{old('penulis') ?? $buku->penulis ?? ''}}">
                            @error('penulis')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control @error('penerbit') {{'is-invalid'}} @enderror" name="penerbit" value="{{old('penerbit') ?? $buku->penerbit ?? ''}}">
                            @error('penerbit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_terbit">Tahun_terbit</label>
                            <input type="date" class="form-control @error('tahun_terbit') {{'is-invalid'}} @enderror" name="tahun_terbit" value="{{old('tahun_terbit') ?? $buku->tahun_terbit ?? ''}}">
                            @error('tahun_terbit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control @error('description') {{'is-invalid'}} @enderror">{{old('description') ?? $buku->description ?? ''}}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input">
                                    <label for="thumbnail" class="custom-file-label">Tambah Gambar</label><br><br>*Jika tidak ingin merubah gambar kosongkan saja
                                    @error('thumbnail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-file">
                                <input type="file" name="pdf" class="custom-file-input">
                                <label for="pdf" class="custom-file-label">Tambah PDF</label><br><br>*Jika tidak ingin merubah pdf kosongkan saja
                                @error('pdf')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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
    @if(isset($buku))
            <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus buku {{$buku->title}}</p>
                    </div>

                    <div class="modal-footer">
                        <form action="{{ route('dashboard.books.delete', $buku->bukuid) }}" method="post">
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