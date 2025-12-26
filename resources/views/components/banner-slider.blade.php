<div
    class="w-full overflow-hidden relative"
>
    <div id="banner-track" class="flex transition-all duration-700">
        @forelse($banners ?? [] as $banner)
            <a href="{{ $banner->redirect_url ?? '#' }}" class="min-w-full">
                
                <!-- 🔒 HEIGHT DIKUNCI DI SINI -->
                <div class="w-full h-52 bg-gray-200 rounded-xl overflow-hidden">
                    <img
                        src="{{ asset('banners/' . $banner->image_path) }}"
                        class="w-full h-full object-cover"
                        loading="eager"
                        decoding="async"
                    />
                </div>

            </a>
        @empty
            <p class="text-center text-gray-400">Tidak ada banner tersedia</p>
        @endforelse
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        let index = 0;
        const track = document.getElementById('banner-track');
        if (!track) return;

        const count = track.children.length;
        if (count <= 1) return;

        setInterval(() => {
            index = (index + 1) % count;
            track.style.transform = `translateX(-${index * 100}%)`;
        }, 4000);
    });
</script>
