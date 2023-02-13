@php
$openModal = false
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <!-- List of posts -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <div class="flex">
                            <h1 class="text-2xl font-bold">Posts</h1>
                            <button class="ml-4 px-4 py-2 bg-blue-500 text-dark rounded-md">
                                <a href="{{ route('posts.create') }}">Create</a>
                            </button>
                        </div>
                        <div class="flex">
                            <form action="{{ route('posts.index') }}" method="GET">
                                <x-text-input type="text" name="search" placeholder="Search" />
                            </form>
                            <!-- Clear search -->
                            <form action="{{ route('posts.index') }}" method="GET">
                                <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-md">Clear</button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-4">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Title</th>
                                    <th class="border border-gray-300 px-4 py-2">Author</th>
                                    <th class="border border-gray-300 px-4 py-2">Created at</th>
                                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                                    <th class="border border-gray-300 px-4 py-2">Public</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $post->title }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $post->user->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $post->created_at }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('posts.show', $post) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">View</a>
                                            <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Edit</a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                                            </form>
                                        </td>
                                        <!-- Switch -->
                                        <td class="border border-gray-300 px-4 py-2">
                                            <form action="{{ route('posts.publicize', $post) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_public" value="{{ $post->is_public ? 0 : 1 }}">
                                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                                    {{ $post->is_public ? 'No' : 'Yes' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type='text/javascript'>


</script>
