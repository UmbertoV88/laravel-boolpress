@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>{{ $post->title}}</h1>
                @if ($post->cover_image)
                    <img src="{{asset('storage/' . $post->cover_image)}}" alt="{{ $post->title }}">
                @endif
                <div class="post-content">
                    {{ $post->content}}
                </div>
                @if (!empty($post->category))
                    <p>Categoria: <a href="{{route('blog.category',['slug' => $post->category->slug])}}">{{$post->category->name}}</a></p>
                @endif
                <p><em>{{$post->author}}</em></p>
            </div>
        </div>
    </div>
@endsection
