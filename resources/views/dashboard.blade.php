<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">{{ __("Welcome to your LARAVEL AI dashboard!") }}</h3>
                    <p class="mb-6">{{ __("Features:") }}</p>

                    <div class="flex space-x-4">
                        <a href="/chat"
                           class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-300">
                            Chat with OpenAI
                        </a>
                        <a href="/chatify"
                           class="px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-300">
                            Chat with Friends
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
