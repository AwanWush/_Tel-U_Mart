<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            Dashboard Super Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center bg-gradient-to-r from-red-600 to-red-800 rounded-lg">
                    <h3 class="text-3xl font-extrabold text-white tracking-wide">
                        Selamat datang, <strong>{{ Auth::user()->name }}</strong> 👑
                    </h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
