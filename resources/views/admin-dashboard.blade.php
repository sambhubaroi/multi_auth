<x-app-layout>
    <x-slot name="header">
    @auth('admin')

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
        @elseauth('student')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>

        @elseauth('teacher')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
        @endauth
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
