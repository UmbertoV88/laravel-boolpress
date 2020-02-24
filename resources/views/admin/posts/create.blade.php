@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="post-title" > Creazione nuovo post</h1>
                <form class="" action="{{route('admin.posts.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titolo">
                    </div>

                    <div class="form-group">
                    <label for="author">Autore</label>
                    <input type="text" class="form-control" id="author" name="author" placeholder="Autore">
                    </div>

                    <div class="form-group">
                    <label for="content">Testo articolo </label>
                    <textarea class="form-control" id="content" placeholder="Inizia a scrivere un articolo..." name="content" rows="8" ></textarea>
                    </div>

                    <div class="form-group">
                    <label for="cover_image">Immagine di copertina </label>
                    <input type="file" class="form-control-file" id="cover_image" name="cover_image_file">
                    </div>

                    <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Crea">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
