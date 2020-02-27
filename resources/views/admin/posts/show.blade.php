@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="post-title" > {{ $post->title }}</h1>
                @if ($post->cover_image)
                    <img src="{{asset('storage/' . $post->cover_image)}}" alt="{{ $post->title }}">
                @endif
                <div class="post-content">
                    {{ $post->content}}
                </div>
                <p>Autore: {{ $post->author}}</p>
                <p>Categoria: {{ $post->category ? $post->category->name : '-' }}</p>
                <p>
                    Tags:
                    @forelse ($post->tags as $tag)
                        {{ $tag->name }}{{ $loop->last ? '' : ','}}
                    @empty
                        -
                    @endforelse
                </p>
                <p>Slug: {{ $post->slug}}</p>
                <p>Creato il: {{ $post->created_at}}</p>
                <p>Modificato il: {{ $post->updated_at}}</p>
            </div>
        </div>
    </div>
@endsection
