<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'likes:id,user_id,post_id']);

        if ($request->has('mine')) {
            $query->where('user_id', auth()->id());
        }

        if ($request->has('author') && !empty($request->author)) {
            $query->where('user_id', $request->author);
        }

// Order by likes_count if sort=likes is provided
        if ($request->has('sort') && $request->sort === 'likes') {
            $query->withCount('likes') // Count likes for each post
            ->orderBy('likes_count', $request->get('order', 'desc'));
        }

// Always order by created_at
        $query->orderBy('created_at', 'desc');

        $posts = $query->paginate(10);

// Transform the response to include only user_id from likes
        $posts->getCollection()->transform(function ($post) {
            return $post->makeHidden(['likes'])->toArray() + [
                    'likes' => $post->likes->pluck('user_id')->unique()->toArray(),
                ];
        });

        return response()->json([
            'success' => true,
            'data' => $posts->items(), // Only return the post data
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'next_page_url' => $posts->nextPageUrl(),
                'prev_page_url' => $posts->previousPageUrl(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = auth()->user()->posts()->create($request->only('title', 'content'));

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post
        ], 201);
    }

    public function show(Post $post)
    {
        return response()->json([
            'success' => true,
            'data' => $post->load(['user', 'likes:id,user_id,post_id'])->makeHidden(['likes'])->toArray() + [
                    'likes' => $post->likes->pluck('user_id')->unique()->toArray(),
                ],
        ]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->only('title', 'content'));

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully.',
            'data' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.'
        ]);
    }
}

