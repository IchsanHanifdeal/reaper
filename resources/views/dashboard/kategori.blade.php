<x-dashboard.main title="Kategori">
    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5 md:gap-6">
        @foreach (['jumlah_kategori', 'kategori_terbaru'] as $type)
            <div class="flex items-center px-4 py-3 bg-neutral border rounded-xl shadow-sm">
                <span
                    class="
                    {{ $type == 'jumlah_kategori' ? 'bg-orange-300' : '' }}
                    {{ $type == 'kategori_terbaru' ? 'bg-orange-300' : '' }}
                    p-3 mr-4 rounded-full">
                </span>
                <div>
                    <p class="text-sm font-medium capitalize text-white">
                        {{ str_replace('_', ' ', $type) }}
                    </p>
                    <p id="{{ $type }}" class="text-lg font-semibold text-white capitalize">
                        {{ $type == 'jumlah_kategori' ? $jumlah_kategori ?? '0' : '' }}
                        {{ $type == 'kategori_terbaru' ? $kategori_terbaru->nama_kategori ?? '0' : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    @if (Auth::user()->role === 'admin')
        <div class="flex flex-col lg:flex-row gap-5">
            @foreach (['tambah_kategori'] as $item)
                <div onclick="{{ $item . '_modal' }}.showModal()"
                    class="flex items-center justify-between p-5 sm:p-7 hover:shadow-md active:scale-[.97] border border-blue-200 bg-white cursor-pointer border-back rounded-xl w-full">
                    <div>
                        <h1 class="flex items-start gap-3 font-semibold font-[onest] sm:text-lg capitalize">
                            {{ str_replace('_', ' ', $item) }}
                        </h1>
                        <p class="text-sm opacity-60">
                            {{ $item == 'tambah_kategori' ? 'Fitur Tambah Kategori memungkinkan pengguna untuk menambahkan kategori baru.' : '' }}
                        </p>
                    </div>
                    <x-lucide-plus
                        class="{{ $item == 'tambah_kategori' ? '' : 'hidden' }} size-5 sm:size-7 opacity-60" />
                </div>
            @endforeach
        </div>
    @endif
    <div class="flex gap-5">
        @foreach (['Daftar_kategori'] as $item)
            <div class="flex flex-col border-back rounded-xl w-full">
                <div class="p-5 sm:p-7 bg-white rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60">
                        Jelajahi dan ketahui kategori terbaru.
                    </p>
                </div>
                <div class="flex flex-col rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    @foreach (['No', 'Kode Kategori', 'Nama Kategori', 'Jumlah Materi'] as $header)
                                        <th class="uppercase font-bold">{{ $header }}</th>
                                    @endforeach
                                    @if (Auth::user()->role === 'admin')
                                        <th class="uppercase font-bold">Jumlah Peserta</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategori as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="font-semibold capitalize">{{ $item->kode_kategori }}</td>
                                        <td class="font-semibold capitalize">{{ $item->nama_kategori }}</td>
                                        <td class="font-semibold capitalize">{{ $item->materi_count }} Materi</td>
                                        @if (Auth::user()->role === 'admin')
                                            <td class="font-semibold capitalize">{{ $item->jumlah_pemilih }} orang</td>

                                            <td class="flex items-center gap-4">
                                                {{-- modal update --}}
                                                <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                    onclick="document.getElementById('update_kategori_{{ $item->id_kategori }}').showModal();" />
                                                <dialog id="update_kategori_{{ $item->id_kategori }}"
                                                    class="modal modal-bottom sm:modal-middle">
                                                    <div class="modal-box bg-neutral text-white">
                                                        <h3 class="text-lg font-bold">Update Kategori</h3>
                                                        <div class="mt-3">
                                                            <form method="POST"
                                                                action="{{ route('edit_kategori', $item->id_kategori) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                @foreach (['kode_kategori', 'nama_kategori'] as $type)
                                                                    <div class="mb-4">
                                                                        <label
                                                                            for="{{ $type . '_' . $item->id_kategori }}"
                                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                                                                        <input type="text"
                                                                            id="{{ $type . '_' . $item->id_kategori }}"
                                                                            name="{{ $type }}"
                                                                            placeholder="Masukan {{ str_replace('_', ' ', $type) }}..."
                                                                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($type) border-red-500 @enderror"
                                                                            value="{{ old($type, $item->$type) }}" />
                                                                        @error($type)
                                                                            <span
                                                                                class="text-red-500 text-sm">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach
                                                                <div class="modal-action">
                                                                    <button type="button"
                                                                        onclick="document.getElementById('update_kategori_{{ $item->id_kategori }}').close()"
                                                                        class="btn">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </dialog>

                                                {{-- Hapus --}}
                                                <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                    onclick="document.getElementById('hapus_modal_{{ $item->id_kategori }}').showModal();" />

                                                <dialog id="hapus_modal_{{ $item->id_kategori }}"
                                                    class="modal modal-bottom sm:modal-middle">
                                                    <div class="modal-box bg-neutral text-white">
                                                        <h3 class="text-lg font-bold">Hapus
                                                            {{ $item->kode_kategori . '-' . $item->nama_kategori }}
                                                        </h3>
                                                        <div class="mt-3">
                                                            <p class="text-red-700 font-semibold">Perhatian! Anda sedang
                                                                mencoba untuk menghapus kategori
                                                                <strong
                                                                    class="text-red-800 font-bold">{{ $item->kode_kategori . ' - ' . $item->nama_kategori }}</strong>.
                                                                <span class="text-gray-600">Tindakan ini akan menghapus
                                                                    semua data terkait. Apakah Anda yakin ingin
                                                                    melanjutkan?</span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="document.getElementById('hapus_modal_{{ $item->id_kategori }}').close()"
                                                                class="btn">Batal</button>
                                                            <form
                                                                action="{{ route('hapus_kategori', $item->id_kategori) }}"
                                                                method="POST" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </dialog>
                                            </td>
                                        @else
                                            <td class="font-semibold capitalize">
                                                <button type="button"
                                                    onclick="document.getElementById('pilih_kategori_{{ $item->id_kategori }}').showModal();"
                                                    class="btn bg-[#7daac4] text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-2 transition-all">
                                                    Tukar Kategori
                                                </button>
                                                <dialog id="pilih_kategori_{{ $item->id_kategori }}"
                                                    class="modal modal-bottom sm:modal-middle">
                                                    <div class="modal-box bg-neutral text-white">
                                                        <h3 class="text-lg font-bold">Tukar Kategori Pelatihan:
                                                            {{ $item->kode_kategori . '-' . $item->nama_kategori }}
                                                        </h3>
                                                        <div class="mt-3">
                                                            <p class="text-yellow-700 font-semibold">
                                                                <strong class="text-red-800">Perhatian!</strong> Anda
                                                                sedang <span class="font-bold">mengubah kategori</span>
                                                                <strong
                                                                    class="text-red-900">{{ $item->kode_kategori . ' - ' . $item->nama_kategori }}</strong>.
                                                                <span class="text-gray-600">Proses ini memerlukan
                                                                    validasi dari admin sebelum perubahan dapat
                                                                    diterapkan. Selama masa validasi, data Anda mungkin
                                                                    tidak dapat diakses atau mengalami perubahan. Apakah
                                                                    Anda yakin ingin melanjutkan?</span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="document.getElementById('pilih_kategori_{{ $item->id_kategori }}').close()"
                                                                class="btn">Batal</button>
                                                            <form
                                                                action="{{ route('ubah_kategori', $item->id_kategori) }}"
                                                                method="POST" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Tukar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </dialog>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada kategori tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard.main>

<dialog id="tambah_kategori_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-neutral text-white">
        <h3 class="text-lg font-bold">Tambah Kategori</h3>
        <div class="mt-3">
            <form method="POST" action="{{ route('tambah_kategori') }}">
                @csrf
                @foreach (['kode_kategori', 'nama_kategori'] as $type)
                    <div class="mb-4 capitalize">
                        <label for="{{ $type }}"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                        <input type="text" id="{{ $type }}" name="{{ $type }}"
                            placeholder="Masukan {{ str_replace('_', ' ', $type) }}..."
                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($type) border-red-500 @enderror capitalize"
                            value="{{ old($type) }}" />
                        @error($type)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
                <div class="modal-action">
                    <button type="button" onclick="document.getElementById('tambah_kategori_modal').close()"
                        class="btn">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</dialog>
