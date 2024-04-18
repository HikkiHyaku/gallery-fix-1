@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ Auth::user()->name }} Gallery</h1>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/album">Home</a></li>
                                <li class="breadcrumb-item active">Gallery</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="/albums/create" class="btn btn-success">Buat Album</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($albums as $album)
                <div class="col-md-4">
                    <div class="card card-primary shadow">
                        <div class="card-body">
                            <img src="{{ asset('storage/album_covers/' . $album->cover_image) }}" style="height: 200px; width: 100%; object-fit: cover;" class="card-img-top" alt="Album Image">

                            <h5 class="card-title">{{$album->name}}</h5>
                            <p class="card-text">{{$album->description}}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{route('albums.show' , $album->id)}}" class="btn btn-primary">Lihat</a>
                                <form method="POST" action="{{ route('albums.destroy', $album->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection
