@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Posts List</h2>

        <!-- Filter & Sorting -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <form method="GET" action="{{ route('posts.index') }}" class="d-flex">
                    <select name="author" class="form-select me-2" onchange="this.form.submit()">
                        <option value="">All Authors</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Create Post</a>
            </div>
        </div>

        <!-- Posts Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Content Preview</th>
                <th>Author</th>
                <th>
                    Likes
                    <a href="?sort=likes_desc" class="ms-2">⬆</a>
                    <a href="?sort=likes_asc">⬇</a>
                </th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ Str::limit($post->content, 50) }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->likes->count() }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">View</a>

                        @if(auth()->id() == $post->user_id)
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
