@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="row m-3">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2 mb-3">
            <h2>CUCI MOBIL</h2>
        </div>
        <!-- Untuk menampilkan form search   -->
        <form class="float-right form-inline" id="searchForm" method="get" action="/dashboard" role="search">
            <div class="form-group">
                <input type="text" name="keyword" class="form-control" id="Keyword" aria-describedby="Keyword" placeholder="Keyword" value="{{request()->query('keyword')}}">
            </div>
            <button type="submit" class="btn btn-primary mx-2">Cari</button>
            <a href="/dashboard">
                <button type="button" class="btn btn-danger">Reset</button>
            </a>
        </form>

        <!-- Tombol tambah resep -->
        <div class="my-2">
            <a class="btn btn-success" href="/dashboard/create"> Tambah Mobil </a>
        </div>
    </div>

    <!-- Untuk Menampilkan Status Jika data berhasil ditambahkan  -->
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{$message}}</p>
    </div>
    @endif
    <div class="col-10">

    <!-- Untuk Menampilkan List Data Tabel Resep -->
    <table class="table table-bordered">
        <tr>
            <th width="250px">Plat Nomor</th>
            <th>Nama Pemilik</th>
            <th>Jenis Mobil</th>
            <th>Harga</th>
            <th>Status</th>
            <th width="280px">Action</th>
            
        </tr>
        @foreach($dashboards as $dashboard)
        <tr>
            <td>{{$dashboard->plat_nomor}}</td>
            <td>{{$dashboard->nama_pemilik}}</td>
            <td>{{$dashboard->jenis->jenis_mobil}}</td>
            
            <td>{{$dashboard->harga}}</td>
            <td>{{$dashboard->status}}</td>
            <td>
                <a href="{{$dashboard->id}}/edit" class="btn btn-primary"> Edit </a>
                <form action="{{$dashboard->id}}" method="POST" class="d-inline"> 
                    @method('delete')
                    <!-- Fungsi csrf untuk mengamankan form -->
                    @csrf 
                    <button type="submit" class="btn btn-danger"> Delete </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    </div>
    <div class="d-flexin">
        {{ $dashboards->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
