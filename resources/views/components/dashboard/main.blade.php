<x-main title="{{ $title }}" class="!p-0" full>
    @if (Auth::user()->role === 'user' && Auth::user()->id_kategori === null)
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold">
                <x-lucide-award class="w-8 h-8 mr-2" alt="logo" /> Reaper
            </a>
            <div class="w-full bg-neutral rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                @php
                    $kategori = App\Models\Kategori::all();
                @endphp
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center uppercase">
                        Pilih Kategori Pelatihan
                    </h1>
                    <div class="flex flex-col items-center justify-between h-full">
                        <form action="{{ route('pilih.kategori', ['id_user' => Auth::user()->id_user]) }}"
                            method="POST" enctype="multipart/form-data" class="w-full">
                            @csrf
                            @method('PUT')
                            <select name="kategori" id="kategori"
                                class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                @forelse ($kategori as $k)
                                    <option value="{{ $k->id_kategori }}">
                                        {{ $k->kode_kategori }} - {{ $k->nama_kategori }}
                                    </option>
                                @empty
                                    <option value="">Tidak ada kategori tersedia</option>
                                @endforelse
                            </select>
                            <div class="flex flex-col items-center justify-center space-y-4 mt-4">
                                <button type="submit"
                                    class="btn w-full max-w-xs bg-primary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center transition duration-300 ease-in-out transform hover:scale-105">
                                    Pilih
                                </button>
                            </div>
                        </form>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <div class="flex flex-col items-center justify-center space-y-4 mt-4">
                                <button type="submit"
                                    class="btn w-full max-w-xs bg-primary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center transition duration-300 ease-in-out transform hover:scale-105">
                                    Keluar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif (Auth::user()->role === 'user' && Auth::user()->validasi === 'menunggu validasi')
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold">
                <x-lucide-award class="w-8 h-8 mr-2" alt="logo" /> Reaper
            </a>
            <div class="w-full bg-neutral rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center uppercase">
                        Menunggu Persetujuan Admin
                    </h1>
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="px-0">
                            @csrf
                            <button type="submit"
                                class="w-full flex flex-col items-center justify-center space-y-4 max-w-xs bg-primary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center transition duration-300 ease-in-out transform hover:scale-105 font-bold">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif (Auth::user()->role === 'user' && Auth::user()->validasi === 'ditolak')
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold">
                <x-lucide-award class="w-8 h-8 mr-2" alt="logo" /> Reaper
            </a>
            <div class="w-full bg-neutral rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center uppercase">
                        Validasi anda ditolak
                    </h1>
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="px-0">
                            @csrf
                            <button type="submit"
                                class="w-full flex flex-col items-center justify-center space-y-4 max-w-xs bg-primary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center transition duration-300 ease-in-out transform hover:scale-105 font-bold">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="drawer md:drawer-open">
            <input id="aside-dashboard" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                @include('components.dashboard.navbar')
                <div class="p-4 md:p-5 bg-stone-100 w-full">
                    <div class="flex flex-col gap-5 md:gap-6 w-full min-h-screen">
                        {{ $slot }}
                    </div>
                </div>
                @include('components.footer')
            </div>
            @include('components.dashboard.aside')
        </div>
    @endif

    <div id="toast-container" class="fixed top-5 right-5 z-50"></div>

    <script>
        function showToast(message, type) {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.classList.add('toast', `toast-${type}`, 'shadow-lg', 'mb-4', 'bg-base-200', 'p-4', 'rounded-lg', 'flex',
                'items-center', 'justify-between');
            toast.innerHTML = `
            <div class="flex-grow">${message}
                <button class="btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.parentElement.remove()">✕</button>
            </div>
        `;
            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('toast-show');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('toast-show');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 5000);
        }

        @if (session('toast'))
            showToast('{{ session('toast.message') }}', '{{ session('toast.type') }}');
        @endif
    </script>
</x-main>
