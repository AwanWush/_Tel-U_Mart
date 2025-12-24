<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            Notifikasi 🔔
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FILTER --}}
            <div class="flex flex-wrap gap-3 mb-4">
                <a href="{{ route('notifications.index') }}"
                   class="px-4 py-2 rounded text-sm
                   {{ request('tab') == null
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white dark:bg-white-800 text-gray-700 dark:text-black-200 shadow' }}">
                    Semua
                </a>

                <a href="{{ route('notifications.index', ['tab' => 'unread']) }}"
                   class="px-4 py-2 rounded text-sm
                   {{ request('tab') == 'unread'
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white dark:bg-white-800 text-gray-700 dark:text-black-200 shadow' }}">
                    Belum Dibaca
                </a>

                <a href="{{ route('notifications.index', ['tab' => 'read']) }}"
                   class="px-4 py-2 rounded text-sm
                   {{ request('tab') == 'read'
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white dark:bg-white-800 text-gray-700 dark:text-black-200 shadow' }}">
                    Sudah Dibaca
                </a>

                <form method="GET" class="ml-auto">
                    <select name="sort"
                            onchange="this.form.submit()"
                            class="border rounded px-8 py-2 text-sm
                                   bg-white dark:bg-white-800
                                   text-gray-700 dark:text-white-200">
                        <option value="desc" {{ request('sort') != 'asc' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                            Terlama
                        </option>
                    </select>
                </form>
            </div>

            {{-- EMPTY --}}
            @if($notifications->count() === 0)
                <div class="bg-white dark:bg-white-800 p-10 text-center rounded shadow">
                    <div class="text-4xl mb-3">🔕</div>
                    <h3 class="text-lg font-semibold text-black-800 dark:text-black-200">
                        Belum ada notifikasi
                    </h3>
                    <p class="text-black-500 dark:text-black-400 mt-2">
                        Notifikasi akan muncul di sini
                    </p>
                </div>
            @endif

            {{-- BULK ACTION --}}
            <form method="POST" id="bulkForm">
                @csrf

                @if($notifications->count() > 0)
                    <div class="flex items-center gap-4 mb-3
                                bg-white dark:bg-gray-800 p-4 rounded shadow">
                        <input type="checkbox" id="selectAll" class="w-5 h-5">

                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Pilih Semua
                        </span>

                        <button
                            formaction="{{ route('notifications.readSelected') }}"
                            class="ml-auto bg-indigo-600 text-white px-3 py-1.5 rounded text-sm">
                            Tandai Dibaca
                        </button>

                        <button
                            formaction="{{ route('notifications.deleteSelected') }}"
                            class="bg-red-500 text-white px-3 py-1.5 rounded text-sm">
                            Hapus
                        </button>
                    </div>
                @endif

                {{-- LIST --}}
                @foreach($notifications as $notif)
                    <div class="mb-3 p-4 rounded shadow flex gap-4 items-start transition
                        {{ $notif->is_read
                            ? 'bg-white dark:bg-gray-800'
                            : 'bg-indigo-50 dark:bg-gray-700 ring-2 ring-indigo-300 dark:ring-indigo-500' }}">

                        <input type="checkbox"
                               name="ids[]"
                               value="{{ $notif->id }}"
                               class="notif-checkbox mt-1 w-5 h-5">

                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200">
                                {{ $notif->title }}
                            </h4>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $notif->body }}
                            </p>

                            <p class="text-xs text-gray-400 mt-2">
                                {{ $notif->created_at->diffForHumans() }}
                                • {{ $notif->is_read ? 'Dibaca' : 'Belum dibaca' }}
                            </p>
                        </div>

                        <div class="flex flex-col gap-2">
                            @if(!$notif->is_read)
                                <a href="{{ route('notifications.read', $notif->id) }}"
                                   class="text-indigo-600 text-sm hover:underline">
                                    Tandai Dibaca
                                </a>
                            @endif

                            <form method="POST" action="{{ route('notifications.destroy', $notif->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 text-sm hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </form>

            <div class="mt-6">
                {{ $notifications->withQueryString()->links() }}
            </div>

        </div>
    </div>

    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.notif-checkbox');

        selectAll?.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

</x-app-layout>