<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->posts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->user_id = $request->user()->id;
        $post->caption = $request->caption;
        $post->save();
        if ($post) {
            return response()->json(['status' => true], 201);
        } else {
            return response()->json(['status' => false], 204);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        if ($request->user()->id == $post->user_id) {
            $post->delete();
            return ['status'=>true];
        } else {
            return 'Hacking Attempt';
        }
    }
}
