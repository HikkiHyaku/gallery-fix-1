@extends('layouts.app')

@section('content')

<div class="container">
    <h1>{{$photo->title}}</h1>
    <a href="/albums/{{$photo->album->id}}" class="btn btn-secondary my-2">Back</a>
    <form action="{{route('photos.destroy' , $photo->id)}}" method="post" class="d-inline">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger my-2">Delete</button>
    </form>
    <div>
        <img src="/storage/albums/{{$photo->album->id}}/{{$photo->photo}}" alt="Photo" class="img-fluid mt-3" style="max-height: 500px;">
    </div>
</div>

@endsection
