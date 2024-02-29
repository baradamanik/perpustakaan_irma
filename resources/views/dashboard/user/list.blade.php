@extends('layouts.dashboard')

@section('content')
    <div class="mb-2">
        <a href="{{route('dashboard.user.create')}}" class="btn btn-primary">+ Tambah User</a>
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
                    <h3>Users</h3>
                </div>

                <div class="col-4">
                    <form method="get" action="{{ route('dashboard.user') }}">
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
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Regitered</th>
                <th>Edited</th>
                <th>&nbsp</th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ ($users->currentPage() -1 ) * $users->perPage() + $loop->iteration }}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->alamat}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
                <td><a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-success btn-sm"><i class="fas fa-pen"></i></a></td>
            </tr>
            @endforeach
        </table>
        {{ $users->appends($request)->links() }}
        </div>
    </div>
@endsection