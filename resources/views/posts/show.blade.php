@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6" style="padding-left: 20px; padding-top: 20px">
        <h2 class="text-3xl font-bold mb-4">{{ $post->title }}</h2>

        <p class="text-gray-600 text-sm mb-2">By <span class="font-semibold">{{ $post->user->name }}</span></p>
        <p class="text-gray-700 mb-4">{{ $post->content }}</p>

        <div class="flex items-center justify-between">
            <p class="text-gray-500"><i class="fas fa-thumbs-up" style="color: black"></i> {{ $post->likes->count() }} Likes</p>

            @auth
                @if (auth()->id() !== $post->user_id)
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Like</button>
                    </form>
                @endif
            @endauth
        </div>

        @if (auth()->id() === $post->user_id)
            <div class="mt-4 d-flex" style="padding-bottom: 20px">
                <button onclick="window.location.href='{{ route('posts.edit', $post) }}'" class="text-white px-4 py-2 rounded-lg" style="background-color: green; padding-right: 20px; margin-right: 20px">
                    Edit
                </button>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg"
                            style="background-color: gainsboro; border-color: gainsboro">Delete</button>
                </form>
            </div>
        @endif
    </div>
@endsection
