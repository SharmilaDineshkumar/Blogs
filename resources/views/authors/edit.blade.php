@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-bold text-center mb-6">Edit Profile</h2>

            <form action="{{ route('authors.update', $author->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $author->name) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500" required>

                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $author->email) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500" required>

                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between mt-6">
                    <a href="{{ route('authors.show', $author->id) }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-600 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-600 transition">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
