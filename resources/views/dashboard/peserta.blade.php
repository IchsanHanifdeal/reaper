<x-dashboard.main title="Peserta">
    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
        @foreach (['jumlah_peserta_menunggu_konfirmasi', 'jumlah_peserta_diterima', 'jumlah_peserta_ditolak'] as $type)
            <div class="flex items-center px-4 py-3 bg-neutral border rounded-xl shadow-sm">
                <span
                    class="
                    {{ $type == 'jumlah_peserta_menunggu_konfirmasi' ? 'bg-orange-300' : '' }}
                    {{ $type == 'jumlah_peserta_diterima' ? 'bg-orange-300' : '' }}
                    {{ $type == 'jumlah_peserta_ditolak' ? 'bg-orange-300' : '' }}
                    p-3 mr-4 rounded-full">
                </span>
                <div>
                    <p class="text-sm font-medium capitalize text-white">
                        {{ str_replace('_', ' ', $type) }}
                    </p>
                    <p id="{{ $type }}" class="text-lg font-semibold text-white">
                        {{ $type == 'jumlah_peserta_menunggu_konfirmasi' ? $jumlah_peserta_menunggu_konfirmasi ?? '0' : '' }}
                        {{ $type == 'jumlah_peserta_diterima' ? $jumlah_peserta_diterima ?? '0' : '' }}
                        {{ $type == 'jumlah_peserta_ditolak' ? $jumlah_peserta_ditolak ?? '0' : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex gap-5">
        @foreach (['Daftar_materi'] as $item)
            <div class="flex flex-col border-back rounded-xl w-full">
                <div class="p-5 sm:p-7 bg-white rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60">
                        Jelajahi dan ketahui materi terbaru.
                    </p>
                </div>
                <div class="flex flex-col rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    @foreach (['No', 'NIK', 'Nama', 'Tempat/Tanggal Lahir', 'Alamat', 'No Handphone', 'Email', 'kategori', 'validasi'] as $header)
                                        <th class="uppercase font-bold">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peserta as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="font-semibold">{{ $item->nik }}</td>
                                        <td class="font-semibold capitalize">{{ $item->nama }}</td>
                                        <td class="font-semibold capitalize">
                                            {{ $item->tempat . '/' . $item->tanggal_lahir }}</td>
                                        <td class="font-semibold capitalize">{{ $item->alamat }}</td>
                                        <td class="font-semibold capitalize">
                                            <a href="https://wa.me/{{ $item->no_hp }}"
                                                class="text-blue-500 cursor-pointer" target="_blank"
                                                rel="noopener noreferrer">
                                                {{ $item->no_hp }}
                                            </a>
                                        </td>
                                        <td class="font-semibold capitalize">{{ $item->email }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->kategori->nama_kategori ?? 'Sedang Memilih Kategori' }}</td>
                                        <td class="font-semibold capitalize text-center">{{ $item->validasi }}</td>
                                        @if ($item->validasi === 'menunggu validasi' && $item->id_kategori === null)
                                            <td class="flex items-center gap-4">
                                                <label for="menungu_kategori"
                                                    class="w-full btn btn-neutral flex items-center justify-center gap-2 text-white font-bold"><span>Menunggu
                                                        Kategori</span></label>
                                            </td>
                                        @elseif ($item->validasi === 'menunggu validasi')
                                            <td class="flex items-center gap-4">
                                                <button
                                                    onclick="document.getElementById('terima_modal_{{ $item->id_user }}').showModal();"
                                                    class="btn btn-neutral">Terima</button> |
                                                <button
                                                    onclick="document.getElementById('tolak_modal_{{ $item->id_user }}').showModal();"
                                                    class="btn btn-error">Tolak</button>
                                            </td>
                                        @elseif ($item->validasi === 'ditolak' || $item->validasi === 'diterima')
                                            <td class="flex items-center gap-4">
                                                {{-- Hapus --}}
                                                <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                    onclick="document.getElementById('hapus_modal_{{ $item->id_user }}').showModal();" />

                                                <dialog id="hapus_modal_{{ $item->id_user }}"
                                                    class="modal modal-bottom sm:modal-middle">
                                                    <div class="modal-box bg-neutral text-white">
                                                        <h3 class="text-lg font-bold">Hapus
                                                            {{ $item->nama }}
                                                        </h3>
                                                        <div class="mt-3">
                                                            <p class="text-red-700 font-semibold">Perhatian! Anda sedang
                                                                mencoba untuk menghapus peserta
                                                                <strong
                                                                    class="text-red-800 font-bold">{{ $item->nama }}</strong>.
                                                                <span class="text-gray-600">Tindakan ini akan menghapus
                                                                    semua data terkait. Apakah Anda yakin ingin
                                                                    melanjutkan?</span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="document.getElementById('hapus_modal_{{ $item->id_user }}').close()"
                                                                class="btn">Batal</button>
                                                            <form action="{{ route('hapus_peserta', $item->id_user) }}"
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
                                            <td class="uppercase">undefined</td>
                                        @endif
                                    </tr>
                                @empty
                                    <td colspan="9" class="text-gray-300 text-center">Tidak ada peserta</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard.main>

@foreach ($peserta as $i => $pe)
    @foreach (['terima', 'tolak'] as $action)
        <dialog id="{{ $action }}_modal_{{ $pe->id_user }}" class="modal modal-bottom sm:modal-middle">
            <form action="{{ route($action . '_' . 'peserta', ['id_user' => $pe->id_user]) }}" method="POST"
                class="modal-box bg-neutral p-6 rounded-lg shadow-lg">
                @csrf
                @method('PUT')
                <h3 class="text-xl font-bold mb-4 text-gray-800 capitalize">
                    {{ ucfirst($action) }} Peserta
                </h3>
                <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                    <p class="text-base font-medium">
                        <strong>Perhatian!</strong> Anda sedang {{ $action }} peserta untuk pelatihan kategori
                        <span class="font-semibold">{{ $pe->kategori->nama_kategori ?? 'Tidak ada Kategori' }}</span>
                        dengan nama
                        <span class="font-semibold">{{ $pe->nama }}</span>.
                        Apakah Anda yakin ingin melanjutkan?
                    </p>
                </div>
                <div class="modal-action">
                    <button
                        onclick="document.getElementById('{{ $action }}_modal_{{ $pe->id_user }}').close();"
                        class="btn btn-secondary" type="button">Tutup</button>
                    <button type="submit" class="btn btn-success capitalize">
                        {{ ucfirst($action) }}
                    </button>
                </div>
            </form>
        </dialog>
    @endforeach
@endforeach
