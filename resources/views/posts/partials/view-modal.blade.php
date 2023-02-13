@props([
    'post',
    'name',
    'show',
])

<x-modal :show="$show" :name="$name">
    <x-slot name="title">
        View Post
    </x-slot>

    <x-slot name="content">
        <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $post->title }}</h1>
            <p class="text-gray-800 dark:text-gray-200">{{ $post->body }}</p>
        </div>
    </x-slot>
</x-modal>
