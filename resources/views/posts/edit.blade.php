@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Post</h2>

        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="text" name="title" class="w-full p-2 border rounded-lg @error('title') border-red-500 @enderror" value="{{ old('title', $post->title) }}" required>
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Content</label>
                <textarea name="content" class="w-full p-2 border rounded-lg @error('content') border-red-500 @enderror" rows="5" required>{{ old('content', $post->content) }}</textarea>
                @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update Post</button>
            <a href="{{ route('posts.index') }}" class="text-gray-600 ml-4">Cancel</a>
        </form>
    </div>
@endsection
