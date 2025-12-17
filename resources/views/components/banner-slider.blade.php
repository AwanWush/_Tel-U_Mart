<div class="w-full overflow-hidden relative">
    <div id="banner-track" class="flex transition-all duration-700">
        @forelse($banners ?? [] as $banner)
            <a href="{{ $banner->redirect_url ?? '#' }}" class="min-w-full">
                <img src="{{ asset('banners/' . $banner->image_path) }}" 
                    class="w-full h-64 object-cover rounded-lg" />
            </a>
        @empty
            <p>Tidak ada banner tersedia</p>
        @endforelse
    </div>
</div>

<script>
    let index = 0;
    setInterval(() => {
        const track = document.getElementById('banner-track');
        const count = track.children.length;
        index = (index + 1) % count;
        track.style.transform = `translateX(-${index * 100}%)`;
    }, 4000);
</script>