@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Users</h3>
                </div>
                <div class="col-4 text-right">
                <button class="btn btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
        

        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form method="post" action="{{ route($url, $user->id ?? '') }}">
                    @csrf
                        @if(isset($user))
                            @method('put')
                        @endif
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') {{'is-invalid'}} @enderror" name="name" value="{{old('name') ?? $user->name ?? ''}}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') {{'is-invalid'}} @enderror" name="email" value="{{old('email') ?? $user->email ?? ''}}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                       <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control @error('alamat') {{'is-invalid'}} @enderror" name="alamat" value="{{old('alamat') ?? $user->alamat ?? ''}}">
                            @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
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
    @if(isset($user))
            <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-email">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus user {{$user->name}}</p>
                    </div>

                    <div class="modal-footer">
                        <form action="{{ route('dashboard.user.delete', $user->id) }}" method="post">
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