<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post Public') }}
        </h2>
    </x-slot>

    <!-- List of posts -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('post-publics.index') }}" method="GET">
                        <x-text-input type="text" name="search" placeholder="Search" />
                        <button type="submit">Search</button>
                    </form>
                    <ul>
                        @foreach ($posts as $post)
                            <li class="border border-gray-300 px-4 py-2 mx-2 my-4">
                                <div class="flex justify-between">
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Title: {{ $post->title }}</h1>
                                        <p class="text-gray-800 dark:text-gray-200">Content: {{ $post->body }}</p>
                                        <p class="text-gray-800 dark:text-gray-200">Created At{{ $post->created_at }}</p>
                                        <p class="text-gray-800 dark:text-gray-200">User: {{ $post->user->name }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('post-publics.show', $post) }}">Show</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
