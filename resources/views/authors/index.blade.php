@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Authors List</h2>

        @if($authors->isEmpty())
            <p class="text-gray-500 text-center">No authors found.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($authors as $author)
                    <div class="bg-white shadow-md rounded-lg p-5 border border-gray-200 hover:shadow-lg transition duration-300">
                        <h3 class="text-lg font-semibold">{{ $author->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $author->email }}</p>
                        <p class="text-gray-500 mt-2 text-sm">Posts: {{ $author->posts->count() }}</p>

                        <a href="{{ route('authors.show', $author->id) }}"
                           class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-600 transition">
                            View Profile
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
