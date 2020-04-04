<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Tag;
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
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create',['categories' => $categories, 'tags'=> $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'content' => 'required',
            'cover_image_file' => 'image'
        ]);
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

        if(!empty($dati['tag_id'])){
            $post->tags()->sync($dati['tag_id']);
        }

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
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::find($id);
        return view('admin.posts.edit', ['post' => $post,'categories' => $categories, 'tags' => $tags]);
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
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'content' => 'required',
            'cover_image_file' => 'image'
        ]);


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
        if(!empty($dati['tag_id'])){
            $post->tags()->sync($dati['tag_id']);
        }
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
        if (!empty($post_image)) {
            Storage::delete($post_image);
        }
        if($post->tags->isNotEmpty()){
            $post->tags()->sync([]);
        }
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
