@extends('layouts.dashboard')

@section('content')
    <div class="mb-2">
        <a href="{{route('dashboard.books.create')}}" class="btn btn-primary">+ Buku</a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Buku</h3>
                </div>
                <div class="col-4">
                    <form method="get" action="{{ route('dashboard.books') }}">
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
            @if($bukubuku->total())
                <table class="table table-bordered table-striped table-hover">
                    <thead>    
                        <tr>
                            <!--<th>No</th>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>&nbsp;</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bukubuku as $buku)
                            <tr>
                                <!--<th>{{ ($bukubuku->currentPage() -1 ) * $bukubuku->perPage() + $loop->iteration }}</th>-->
                                <td class="col-thumbnail">
                                    <img src="{{asset('storage/buku/'.$buku->thumbnail)}}" class="img-fluid">
                                </td>
                                <td>
                                    <h4><strong>{{ $buku->title }}</strong></h4>
                                </td>
                                <td><a href="{{ route('dashboard.books.edit', $buku->bukuid) }}" class="btn btn-success btn-sm"><i class="fas fa-pen"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bukubuku->links() }}
            @else
                <h5 class="text-center p-3">Belum ada data Buku</h5>
            @endif
        </div>
    </div>
@endsection