<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    /**
     * Get a list of all authors.
     */
    public function index()
    {
        $authors = User::all();
        return response()->json($authors);
    }

    /**
     * Show details of a specific author, including their posts and post count.
     */
    public function show($id)
    {
        $author = User::findOrFail($id);
        $posts = Post::where('author_id', $author->id)->get();
        $postCount = $posts->count();

        return response()->json([
            'author' => $author,
            'posts' => $posts,
            'post_count' => $postCount,
        ]);
    }

    /**
     * Update an author's details (only if the authenticated user is the author).
     */
    public function update(Request $request, $id)
    {
        $author = User::findOrFail($id);

        if ($author->id != Auth::id()) {
            return response()->json(['error' => 'You cannot edit another user\'s profile.'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $author->update($request->only(['name', 'email']));

        return response()->json([
            'message' => 'Profile updated successfully.',
            'author' => $author
        ]);
    }

    /**
     * Delete an author and their related posts (only if the authenticated user is the author).
     */
    public function destroy($id)
    {
        $author = User::findOrFail($id);

        if ($author->id != Auth::id()) {
            return response()->json(['error' => 'You cannot delete another user\'s profile.'], 403);
        }

        $author->delete();

        return response()->json(['message' => 'Author deleted successfully.']);
    }
}
