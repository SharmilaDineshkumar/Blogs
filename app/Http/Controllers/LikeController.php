<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        if ($post->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot like your own post.');
        }

        auth()->user()->likes()->create(['post_id' => $post->id]);

        return redirect()->back()->with('success', 'Post liked.');
    }

    public function destroy(Post $post)
    {
        auth()->user()->likes()->where('post_id', $post->id)->delete();

        return redirect()->back()->with('success', 'Like removed.');
    }
}
