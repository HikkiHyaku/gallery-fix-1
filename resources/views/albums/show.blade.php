@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- Mengatur margin atas menjadi 0 untuk menghapus jarak -->
                    <h1>Album </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/album">Home</a></li>
                        <li class="breadcrumb-item active">{{$album->name}} Album</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Display the username outside the loop -->
            <div class="row py-lg-5 shad text-center">
                <div class="col-lg-9 col-md-10 mx-auto"> <!-- Sesuaikan lebar kolom agar tidak bertabrakan dengan sidebar -->
                    <h1> {{$album->name}}</h1>
                    <p class="lead text-muted">{{$album->description}}</p>
                    <p>
                        <a href="/photo/upload/{{$album->id}}" class="btn btn-primary my-2">Upload Photo</a>
                        <a href="/albums" class="btn btn-secondary my-2">Back</a>
                    </p>
                </div>
            </div>
            <div class="row">
@if (count($album->photos) > 0)
    @foreach ($album->photos as $photo)
        <div class="col-md-4 mb-4">
            <div class="shadow">
                <div class="card">
                    <img src="/storage/albums/{{$album->id}}/{{$photo->photo}}" class="card-img-top" alt="photo Image">
                    <div class="card-body">
                        <h5 class="card-title">{{$photo->name}}</h5>
                        <p class="card-text">{{$photo->description}}</p>
                        <div class="button-group">
                            <a href="{{route('photos.show' , $photo->id)}}" class="btn btn-primary">View</a>
                            <form id="like-form-{{$photo->id}}" method="POST" action="{{ route('likes.toggle', $photo->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary" id="like-btn-{{$photo->id}}">Like</button>
                            </form>
                            <form method="POST" action="{{ route('comments.store', $photo->id) }}">
                                @csrf
                                <textarea name="content" rows="3" placeholder="Tambahkan komentar"></textarea>
                                <button type="submit" class="btn btn-success">Komentar</button>
                            </form>
                        </div>
                        <!-- Daftar Komentar -->
                        <div class="comment-list">
                            @foreach ($photo->photoComments as $comment)
                                <p>{{ $comment->user->name }}: {{ $comment->content }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-md-12">
        <p>No photos to display</p>
    </div>
@endif
</div>

        </div>
    </section>
</div>

@endsection

@section('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script>
    $(document).ready(function() {
        // Saat dokumen dimuat, periksa apakah pengguna telah memberikan "like" pada setiap foto
        @foreach($album->photos as $photo)
        $.ajax({
            url: "{{ route('likes.check', $photo->id) }}",
            type: "GET",
            success: function(response) {
                if (response.liked) {
                    // Jika sudah dilike, sembunyikan tombol Like
                    $('#like-form-{{$photo->id}}').hide();
                }
            }
        });
        @endforeach

        // Event handler untuk form Like
        $('form[id^="like-form"]').submit(function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir secara default
            var form = $(this);
            var url = form.attr('action');

            // Kirim permintaan AJAX
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Tampilkan pesan dari respons
                    alert(response.message);

                    // Perbarui tampilan tombol
                    form.hide();
                    form.siblings('.unlike-form').show();
                },
                error: function(xhr) {
                    // Tangani kesalahan
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });

        // Event handler untuk form Unlike
        $('form[id^="unlike-form"]').submit(function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir secara default
            var form = $(this);
            var url = form.attr('action');

            // Kirim permintaan AJAX
            $.ajax({
                url: url,
                type: 'DELETE',
                data: form.serialize(),
                success: function(response) {
                    // Tampilkan pesan dari respons
                    alert(response.message);

                    // Perbarui tampilan tombol
                    form.hide();
                    form.siblings('.like-form').show();
                },
                error: function(xhr) {
                    // Tangani kesalahan
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
