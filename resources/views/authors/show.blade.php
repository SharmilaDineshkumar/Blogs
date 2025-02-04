@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-bold mb-4 text-center">{{ $author->name }}</h2>
            <p class="text-gray-600 text-center">{{ $author->email }}</p>

            <div class="mt-4 text-center">
                <span class="bg-gray-200 text-gray-700 px-4 py-1 rounded-md text-sm">
                    Total Posts: {{ $author->posts->count() }}
                </span>
            </div>

            @if(auth()->id() == $author->id)
                <div class="mt-4 flex justify-center space-x-4">
                    <a href="{{ route('authors.edit', $author->id) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded-md text-sm hover:bg-yellow-600 transition">
                        Edit Profile
                    </a>
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete your profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm hover:bg-red-600 transition">
                            Delete Profile
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <h3 class="text-xl font-semibold mt-8 mb-4">Posts by {{ $author->name }}</h3>

        @if($author->posts->isEmpty())
            <p class="text-gray-500">No posts found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($author->posts as $post)
                    <div class="bg-white shadow-md rounded-lg p-5 border border-gray-200 hover:shadow-lg transition duration-300">
                        <h4 class="text-lg font-semibold">{{ $post->title }}</h4>
                        <p class="text-gray-600 text-sm">{{ Str::limit($post->content, 100) }}</p>

                        <a href="{{ route('posts.show', $post->id) }}"
                           class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-600 transition">
                            Read More
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
