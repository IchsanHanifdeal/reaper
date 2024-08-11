<x-dashboard.main title="Dashboard">
    @if (Auth::user()->role === 'admin')
        <div class="grid sm:grid-cols-1 xl:grid-cols-3 gap-5 md:gap-6">
            @foreach (['jumlah_peserta', 'jumlah_kategori', 'jumlah_materi'] as $type)
                <div class="flex items-center px-4 py-3 bg-neutral border rounded-xl shadow-sm">
                    <span
                        class="
                        {{ $type == 'jumlah_peserta' ? 'bg-orange-300' : '' }}
                        {{ $type == 'jumlah_kategori' ? 'bg-orange-300' : '' }}
                        {{ $type == 'jumlah_materi' ? 'bg-orange-300' : '' }}
                        p-3 mr-4 rounded-full">
                    </span>
                    <div>
                        <p class="text-sm font-medium capitalize text-white">
                            {{ str_replace('_', ' ', $type) }}
                        </p>
                        <p id="{{ $type }}" class="text-lg font-semibold text-white">
                            {{ $type == 'jumlah_peserta' ? $jumlah_peserta ?? '0' : '' }}
                            {{ $type == 'jumlah_kategori' ? $jumlah_kategori ?? '0' : '' }}
                            {{ $type == 'jumlah_materi' ? $jumlah_materi ?? '0' : '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5 md:gap-6">
            @foreach (['jumlah_kategori', 'jumlah_materi'] as $type)
                <div class="flex items-center px-4 py-3 bg-neutral border rounded-xl shadow-sm">
                    <span
                        class="
                    {{ $type == 'jumlah_kategori' ? 'bg-orange-300' : '' }}
                    {{ $type == 'jumlah_materi' ? 'bg-orange-300' : '' }}
                    p-3 mr-4 rounded-full">
                    </span>
                    <div>
                        <p class="text-sm font-medium capitalize text-white">
                            {{ str_replace('_', ' ', $type) }}
                        </p>
                        <p id="{{ $type }}" class="text-lg font-semibold text-white">
                            {{ $type == 'jumlah_kategori' ? $jumlah_kategori ?? '0' : '' }}
                            {{ $type == 'jumlah_materi' ? $jumlah_materi ?? '0' : '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="flex flex-col xl:flex-row gap-5">
        @foreach (['kategori', 'materi'] as $jenis)
            <div class="flex flex-col border rounded-xl w-full">
                <div class="p-5 sm:p-7 bg-neutral rounded-t-xl text-white">
                    <h1 class="flex items-start gap-3 font-semibold sm:text-lg capitalize">
                        {{ str_replace('_', ' ', $jenis) }}
                        <span class="badge badge-xs sm:badge-sm uppercase badge-primary">baru</span>
                    </h1>
                    <p class="text-sm opacity-60">Berdasarkan data pada {{ date('d-m-Y') }}</p>
                </div>
                <div class="flex flex-col bg-zinc-300 rounded-b-xl gap-3 divide-y pt-0 p-5 max-h-64 overflow-y-auto">
                    @forelse (${$jenis}->take(5) as $index => $data)
                        <div class="flex items-center gap-5 pt-3">
                            <h1>{{ $index + 1 }}</h1>
                            <div>
                                <h1 class="opacity-50 text-sm font-semibold">
                                    #kode {{ $data->{'kode_' . $jenis} }}
                                </h1>
                                <h1 class="font-semibold text-sm sm:text-[15px] hover:underline cursor-pointer">
                                    @if ($jenis === 'materi')
                                        {{ ucfirst($data->nama_materi) }}
                                    @elseif ($jenis === 'kategori')
                                        {{ ucfirst($data->nama_kategori) }}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center gap-5 pt-3">
                            <h1>Tidak ada {{ $jenis }} terbaru.</h1>
                        </div>
                    @endforelse

                    @if (${$jenis}->count() > 5)
                        @foreach (${$jenis}->slice(5) as $index => $data)
                            <div class="flex items-center gap-5 pt-3">
                                <h1>{{ $index + 1 }}</h1>
                                <div>
                                    <h1 class="opacity-50 text-sm font-semibold">
                                        #kode {{ $data->{'kode_' . $jenis} }}
                                    </h1>
                                    <h1 class="font-semibold text-sm sm:text-[15px] hover:underline cursor-pointer">
                                        @if ($jenis === 'materi')
                                            {{ ucfirst($data->nama_materi) }}
                                        @elseif ($jenis === 'kategori')
                                            {{ ucfirst($data->nama_kategori) }}
                                        @endif
                                    </h1>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard.main>
