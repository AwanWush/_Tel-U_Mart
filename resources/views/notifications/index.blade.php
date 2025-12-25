<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Notifikasi 🔔</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- FILTER --}}
        <div class="flex gap-3 mb-4">
            <a href="{{ route('notifications.index') }}" class="px-4 py-2 rounded {{ request('tab')==null?'bg-red-600 text-white':'bg-white shadow' }}">Semua</a>
            <a href="{{ route('notifications.index',['tab'=>'unread']) }}" class="px-4 py-2 rounded {{ request('tab')=='unread'?'bg-red-600 text-white':'bg-white shadow' }}">Belum Dibaca</a>
            <a href="{{ route('notifications.index',['tab'=>'read']) }}" class="px-4 py-2 rounded {{ request('tab')=='read'?'bg-red-600 text-white':'bg-white shadow' }}">Sudah Dibaca</a>

            <form class="ml-auto">
                <select name="sort" onchange="this.form.submit()" class="border px-8 py-2 rounded">
                    <option value="desc">Terbaru</option>
                    <option value="asc" {{ request('sort')=='asc'?'selected':'' }}>Terlama</option>
                </select>
            </form>
        </div>

        @if($notifications->count() === 0)
            <div class="bg-white p-10 text-center rounded shadow">
                <div class="text-4xl">🔕</div>
                <p>Belum ada notifikasi</p>
            </div>
        @endif

        <form method="POST">
            @csrf

            @foreach($notifications as $notif)
                @php
                $color = match($notif->type) {
                    'transaction' => 'bg-green-50 border-green-400',
                    'information' => 'bg-blue-50 border-blue-400',
                    'warning' => 'bg-yellow-50 border-yellow-400',
                    'urgent' => 'bg-red-50 border-red-400',
                    default => 'bg-gray-50 border-gray-400',
                };
                @endphp

                <div class="border-l-4 {{ $color }} p-4 mb-3 rounded shadow flex gap-4">
                    <input type="checkbox" name="ids[]" value="{{ $notif->id }}">

                    <div class="flex-1">
                        <h4 class="font-semibold">{{ $notif->title }}</h4>
                        <p class="text-sm">{{ $notif->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $notif->created_at->diffForHumans() }} • {{ $notif->is_read?'Dibaca':'Belum dibaca' }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-2">
                        @if(!$notif->is_read)
                            <a href="{{ route('notifications.read',$notif->id) }}" class="text-sm text-blue-600">Tandai Dibaca</a>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy',$notif->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-red-500">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </form>

        {{ $notifications->links() }}
    </div>
</x-app-layout>
