<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = User::all();
        return view('authors.index', compact('authors'));
    }

    public function show($id)
    {
        $author = User::findOrFail($id);
        $posts = Post::where('user_id', $author->id)->get();
        $postCount = $posts->count();
        return view('authors.show', compact('author', 'posts', 'postCount'));
    }

    public function edit($id)
    {
        $author = User::findOrFail($id);
        if ($author->id != auth()->id()) {
            return redirect()->route('authors.show', $id)->with('error', 'You cannot edit another user\'s profile.');
        }
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $author = User::findOrFail($id);

        if ($author->id != auth()->id()) {
            return redirect()->route('authors.show', $id)->with('error', 'You cannot edit another user\'s profile.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email,' . $id,
        ]);

        $author->update($request->all());
        return redirect()->route('authors.show', $author->id)->with('success', 'Profile updated successfully.');
    }

    public function destroy($id)
    {
        $author = User::findOrFail($id);

        if ($author->id != auth()->id()) {
            return redirect()->route('authors.show', $id)->with('error', 'You cannot delete another user\'s profile.');
        }

        // Delete author and all related posts
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
