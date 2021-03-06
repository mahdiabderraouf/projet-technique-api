<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // return Post::latest()->get();
       $posts = Post::all();
       return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBlogRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $data = $request->validated();
 
        return Post::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateBlogRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, Post $post)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $data = $request->validated();

        $post->update($data);

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $post->delete();
        return [
         'success' => 'Post deleted successfully.'
               ];
    }
}
