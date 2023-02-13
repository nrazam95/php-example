<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <!-- Show post -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $post->title }}</h1>
                    <p class="text-gray-800 dark:text-gray-200">{{ $post->body }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

