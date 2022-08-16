<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\StorePost;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param  \App\Http\Requests\StorePost $request
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('verified')->except(['index', 'show']);
    }
    
    public function index()
    {
        // $posts = Post::latest()->get();
        $posts = Post::latest()->paginate(5);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $request->user()->id;
        $post->save();
        // return redirect('posts/'.$post->id);
        return redirect('posts/' . $post->id)->with('my_status', __('Posted new article.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePost $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, Post $post)
    {
        $this->authorize('edit', $post);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        // return redirect('posts/' . $post->id);
        return redirect('posts/' . $post->id)->with('my_status', __('Updated an article.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        $post->delete();
        // return redirect('posts');
        return redirect('posts')->with('my_status', __('Deleted an article.'));
    }
}
