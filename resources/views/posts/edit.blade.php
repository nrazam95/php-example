<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <!-- Edit post form -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-drk dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold">Edit post</h1>
                    <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST" class="mt-4">
                        {{ method_field('PUT') }}
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Title</label>
                            <input type="text" name="title" id="title" class="border border-gray-300 dark:bg-gray-900 bg-dark rounded-md px-4 py-2 w-full" value="{{ $post->title }}">
                        </div>
                        <div class="mb-4">
                            <label for="body" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Body</label>
                            <textarea name="body" id="body" class="border border-gray-300 dark:bg-gray-900 rounded-md px-4 py-2 w-full" rows="4">{{ $post->body }}</textarea>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                        </div>
                        <div class="mb-4">
                            <a type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md" href="{{route('posts.index')}}">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    .textarea, .select {
        background-color: black !important;
    }
</style>
