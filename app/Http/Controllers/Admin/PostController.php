<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', ['posts' =>  $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all()); visualizzo tutti i dati inseriti nel form
        $dati = $request->all();

        $post = new Post();
        $post->fill($dati);

        if (!empty($dati['cover_image_file'])) {
            $cover_image = $dati['cover_image_file'];
            $cover_image_path = Storage::put('uploads',$cover_image );
            $post->cover_image = $cover_image_path;
        }

        $slug_originale = Str::slug($dati['title']);
        $slug = $slug_originale;
        // verifico che nel db non esista uno slug uguale
        $post_stesso_slug = Post::where('slug', $slug)->first();
        $slug_trovati = 1;
        while(!empty($post_stesso_slug)) {
            $slug = $slug_originale . '-' . $slug_trovati;
            $post_stesso_slug = Post::where('slug', $slug)->first();
            $slug_trovati++;
        }
        $post->slug = $slug;
        $post->save();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('admin.posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $dati = $request->all();
        if (!empty($dati['cover_image_file'])) {
            if (!empty($post->cover_image)) {
                Storage::delete($post->cover_image);

            }
            $cover_image = $dati['cover_image_file'];
            $cover_image_path = Storage::put('uploads',$cover_image );
            $dati['cover_image'] = $cover_image_path;
        }
        $post->update($dati);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post_image = $post->cover_image;
        Storage::delete($post_image);

        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
