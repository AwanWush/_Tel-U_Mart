<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <h3 class="text-3xl font-extrabold text-white tracking-wide">
                        Selamat datang, <strong>{{ Auth::user()->name }}</strong> 👋
                    </h3>
                    <p class="mt-2 text-lg text-gray-300">Anda login sebagai <b>Admin</b>.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
