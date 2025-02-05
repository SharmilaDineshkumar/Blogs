<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        if ($post->user_id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot like your own post.'
            ], 403);
        }

        if (auth()->user()->likes()->where('post_id', $post->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You have already liked this post.'
            ], 400);
        }

        $post->increment('likes_count');
        auth()->user()->likes()->create(['post_id' => $post->id]);

        return response()->json([
            'success' => true,
            'message' => 'Post liked successfully.',
            'likes_count' => $post->likes_count
        ]);
    }

    public function destroy(Post $post)
    {
        if (!auth()->user()->likes()->where('post_id', $post->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You have not liked this post.'
            ], 400);
        }

        $post->decrement('likes_count');
        auth()->user()->likes()->where('post_id', $post->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Like removed successfully.',
            'likes_count' => $post->likes_count
        ]);
    }
}
