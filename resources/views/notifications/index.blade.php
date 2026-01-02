<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-black text-2xl text-[#5B000B] tracking-widest uppercase">Notifikasi 🔔</h2>

            <div class="flex gap-2">
                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-[#E7BD8A] hover:bg-[#E68757] text-[#5B000B] px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg">
                        Tandai Semua Dibaca
                    </button>
                </form>

                <form action="{{ route('notifications.deleteAll') }}" method="POST"
                    onsubmit="return confirm('Hapus permanen semua notifikasi Anda?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-[#930014] hover:bg-[#5B000B] text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg border border-white/10">
                        Bersihkan Semua
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-[#E7BD8A]/10 border border-[#E7BD8A]/50 text-[#DC2626] rounded-2xl font-bold flex items-center animate-pulse">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

            <div class="flex flex-wrap gap-4 mb-8 items-center">
                <div class="flex bg-[#5B000B] p-1.5 rounded-2xl border border-white/5 shadow-2xl">
        <a href="{{ route('notifications.index') }}"
            class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition
            {{ request('tab') == null ? 'bg-[#DB4B3A] text-white shadow-xl' : 'text-white/80 hover:text-white' }}">
            Semua
        </a>

        <a href="{{ route('notifications.index', ['tab' => 'unread']) }}"
            class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition
            {{ request('tab') == 'unread' ? 'bg-[#DB4B3A] text-white shadow-xl' : 'text-white/80 hover:text-white' }}">
            Belum Dibaca
        </a>

        <a href="{{ route('notifications.index', ['tab' => 'read']) }}"
            class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition
            {{ request('tab') == 'read' ? 'bg-[#DB4B3A] text-white shadow-xl' : 'text-white/80 hover:text-white' }}">
            Sudah Dibaca
        </a>
    </div>


            <form class="ml-auto">
                <select name="sort" onchange="this.form.submit()"
                    class="bg-[#5B000B] border-none rounded-xl px-6 py-2 text-[10px] font-black uppercase tracking-widest text-[#E7BD8A] focus:ring-[#DB4B3A] shadow-lg cursor-pointer">
                    <option value="desc">Urutan: Terbaru</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Urutan: Terlama</option>
                </select>
            </form>
        </div>

        @if ($notifications->isEmpty())
            <div class="bg-[#5B000B]/50 p-20 text-center rounded-[3rem] border border-white/5 shadow-inner">
                <div class="text-7xl mb-6 opacity-20">🔕</div>
                <p class="text-[#E7BD8A] font-black uppercase tracking-[0.2em] text-xs">Tidak ada pemberitahuan baru</p>
            </div>
        @endif

        <div class="space-y-4">
            @foreach ($notifications as $notif)
                @php
                    $borderColor = !$notif->is_read ? 'border-[#DB4B3A]' : 'border-[#930014]';
                    $bgColor = 'bg-[#5B000B]';
                @endphp

                <div
                    class="group border-l-8 {{ $borderColor }} {{ $bgColor }} p-6 rounded-[2rem] shadow-sm hover:shadow-2xl transition-all flex flex-col md:flex-row gap-6 items-start md:items-center relative">

                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4
                                class="font-black text-lg tracking-tighter uppercase {{ !$notif->is_read ? 'text-[#E7BD8A]' : 'text-gray-400' }}">
                                {{ $notif->title }}
                            </h4>
                            @if (!$notif->is_read)
                                <span
                                    class="bg-[#DB4B3A] text-white text-[8px] font-black px-2 py-0.5 rounded uppercase animate-pulse">NEW</span>
                            @endif
                        </div>
                        <p class="text-gray-300 text-sm font-medium leading-relaxed">{{ $notif->message }}</p>

                        <div class="flex items-center gap-6 mt-4">
                            <span class="text-[10px] font-black text-[#E7BD8A]/50 uppercase tracking-widest">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>

                            @if (str_contains(strtolower($notif->title), 'pesanan') || str_contains(strtolower($notif->message), 'tm-'))
                                <a href="{{ route('riwayat.pembelian') }}"
                                    class="text-[10px] font-black text-[#E68757] hover:text-[#E7BD8A] uppercase tracking-widest underline underline-offset-4 decoration-2">
                                    DETAIL TRANSAKSI →
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        @if (!$notif->is_read)
                            <a href="{{ route('notifications.read', $notif->id) }}"
                                class="flex-1 md:flex-none text-center px-6 py-2 bg-[#E7BD8A] hover:bg-white text-[#FFFFFF] rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-md">
                                BACA
                            </a>
                        @endif

                        <form method="POST" action="{{ route('notifications.destroy', $notif->id) }}"
                            class="flex-1 md:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-6 py-2 bg-[#930014] hover:bg-black text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-md">
                                HAPUS
                            </button>
                        </form>
                    </div> 
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>