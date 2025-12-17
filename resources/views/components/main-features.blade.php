<div class="max-w-7xl mx-auto p-4">
    @auth
        <div class="bg-blue-50 p-4 rounded-xl mb-6">
            <h2 class="text-xl font-semibold">
                Selamat datang kembali, {{ auth()->user()->name }} !
            </h2>
            <p class="text-gray-600">Selamat mencari barang yang anda butuhkan!</p>
        </div>
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('token.index') }}" class="bg-white shadow p-6 rounded-xl flex gap-4 items-center">
            @include('icons.electricity')
            <div>
                <h3 class="font-semibold text-lg">Token Listrik</h3>
                <p class="text-sm text-gray-500">Isi ulang token listrik dengan cepat.</p>
            </div>
        </a>

        <a href="{{ route('galon.index') }}" class="bg-white shadow p-6 rounded-xl flex gap-4 items-center">
            @include('icons.gallon')
            <div>
                <h3 class="font-semibold text-lg">Galon Asrama</h3>
                <p class="text-sm text-gray-500">Pesan air galon langsung antar ke asrama.</p>
            </div>
        </a>
    </div>
</div>