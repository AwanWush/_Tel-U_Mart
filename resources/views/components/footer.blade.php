@php
    $isUser = auth()->check() && auth()->user()->role_id == 3;
@endphp
@if($isUser)
<footer class="bg-[#5B000B] text-white py-12 mt-20 font-sans border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            {{-- Branding Section --}}
            @if($isUser)
            <div class="col-span-2 md:col-span-1">
                {{-- Logo disesuaikan dengan style: text-xl font-bold text-[#930014] --}}
                <a href="/" class="text-xl font-bold tracking-wide text-[#ffffff] hover:text-[#DB4B3A] transition">
                    TJ&TMart
                </a>
                <p class="text-[12px] text-gray-200 leading-relaxed max-w-[200px] font-medium opacity-90 mt-4">
                    Belanja kebutuhan asrama dengan cepat dan mudah.
                </p>
            </div>
            @endif

            {{-- Menu Section --}}
            @if($isUser)
            <div>
                <h4 class="text-[11px] font-white font-bold uppercase tracking-[0.2em] mb-5">Menu</h4>
                <ul class="space-y-3">
                    <li><a href="/dashboard" class="text-[12px] text-white/80 hover:text-[#DB4B3A] transition-all font-medium">Home</a></li>
                    <li><a href="/wishlist" class="text-[12px] text-white/80 hover:text-[#DB4B3A] transition-all font-medium">Wishlist</a></li>
                    <li><a href="/cart" class="text-[12px] text-white/80 hover:text-[#DB4B3A] transition-all font-medium">Cart</a></li>
                </ul>
            </div>

            {{-- Bantuan Section --}}
            <div>
                <h4 class="text-[11px] font-white font-bold uppercase tracking-[0.2em] mb-5">Bantuan</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('faq.index') }}" class="text-[12px] text-white/80 hover:text-[#DB4B3A] transition-all font-medium">FAQ</a></li>
                    <li><a href="{{ route('kontak.index') }}" class="text-[12px] text-white/80 hover:text-[#DB4B3A] transition-all font-medium">Kontak</a></li>
                    <li><a href="{{ route('tentang.index') }}" class="text-[12px] text-white/80 hover:text-[#DB4B3A] transition-all font-medium">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- Asrama Section --}}
            <div>
                <h4 class="text-[11px] font-white font-bold uppercase tracking-[0.2em] mb-5">Asrama</h4>
                <div class="space-y-3">
                    <p class="text-[11px] text-gray-200 leading-tight italic">
                        Gedung Asrama Putra & Putri.
                    </p>
                    <p class="text-[11px] text-gray-200 font-bold tracking-tight mt-2">
                        Lokasi dan Layanan Asrama.
                    </p>
                </div>
            </div>
            
        </div>
        @endif

        {{-- Bottom Footer --}}
        @if($isUser)
        <div class="mt-16 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] font-bold text-red-300/60 uppercase tracking-widest">
                © {{ date('Y') }} TJ&TMart — All Rights Reserved.
            </p>
            <div class="flex gap-6">
                <a href="#" class="text-white/40 hover:text-[#DB4B3A] transition-all text-[10px] font-black uppercase tracking-tighter italic">Instagram</a>
                <a href="#" class="text-white/40 hover:text-[#DB4B3A] transition-all text-[10px] font-black uppercase tracking-tighter italic">Telegram</a>
            </div>
        </div>
        @endif
    </div>
</footer>

<style>
    .font-sans { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif !important; }
</style>
@endif