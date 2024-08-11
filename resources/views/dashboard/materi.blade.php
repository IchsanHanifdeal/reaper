<x-dashboard.main title="Materi">
    <div class="grid sm:grid-cols-1 xl:grid-cols-2 gap-5 md:gap-6">
        @foreach (['jumlah_materi', 'materi_terbaru'] as $type)
            <div class="flex items-center px-4 py-3 bg-neutral border rounded-xl shadow-sm">
                <span
                    class="
                    {{ $type == 'jumlah_materi' ? 'bg-orange-300' : '' }}
                    {{ $type == 'materi_terbaru' ? 'bg-orange-300' : '' }}
                    p-3 mr-4 rounded-full">
                </span>
                <div>
                    <p class="text-sm font-medium capitalize text-white">
                        {{ str_replace('_', ' ', $type) }}
                    </p>
                    <p id="{{ $type }}" class="text-lg font-semibold text-white">
                        {{ $type == 'jumlah_materi' ? $jumlah_materi ?? '0' : '' }}
                        {{ $type == 'materi_terbaru' ? $materi_terbaru->nama_materi ?? '0' : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    @if (Auth::user()->role === 'admin')
        <div class="flex flex-col lg:flex-row gap-5">
            @foreach (['tambah_materi'] as $item)
                <div onclick="{{ $item . '_modal' }}.showModal()"
                    class="flex items-center justify-between p-5 sm:p-7 hover:shadow-md active:scale-[.97] border border-blue-200 bg-white cursor-pointer border-back rounded-xl w-full">
                    <div>
                        <h1 class="flex items-start gap-3 font-semibold font-[onest] sm:text-lg capitalize">
                            {{ str_replace('_', ' ', $item) }}
                        </h1>
                        <p class="text-sm opacity-60">
                            {{ $item == 'tambah_materi' ? 'Fitur Tambah materi memungkinkan pengguna untuk menambahkan materi baru.' : '' }}
                        </p>
                    </div>
                    <x-lucide-plus class="{{ $item == 'tambah_materi' ? '' : 'hidden' }} size-5 sm:size-7 opacity-60" />
                </div>
            @endforeach
        </div>
    @endif
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
                                    @foreach (['No', 'Tanggal Upload', 'Kode Materi', 'Nama Materi', 'File Materi', 'Kategori'] as $header)
                                        <th class="uppercase font-bold">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($materi as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="font-semibold capitalize">{{ $item->tanggal_upload }}</td>
                                        <td class="font-semibold capitalize">{{ $item->kode_materi }}</td>
                                        <td class="font-semibold capitalize">{{ $item->nama_materi }}</td>
                                        <td class="font-semibold capitalize">
                                            <label for="lihat_modal_{{ $item->id_materi }}"
                                                class="w-full btn btn-neutral flex items-center justify-center gap-2 text-white font-bold">
                                                <span>Lihat</span>
                                            </label>
                                            <input type="checkbox" id="lihat_modal_{{ $item->id_materi }}"
                                                class="modal-toggle" />
                                            <div class="modal" role="dialog">
                                                <div class="modal-box" id="modal_box_{{ $item->id_materi }}">
                                                    <div class="modal-header flex justify-between items-center">
                                                        <h3 class="text-lg font-bold">File Materi
                                                            {{ $item->nama_materi }}</h3>
                                                        <label for="lihat_modal_{{ $item->id_materi }}"
                                                            class="btn btn-sm btn-circle btn-ghost">&times;</label>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($item->file_materi)
                                                            @php
                                                                $fileExtension = pathinfo(
                                                                    $item->file_materi,
                                                                    PATHINFO_EXTENSION,
                                                                );
                                                            @endphp

                                                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                <img src="{{ asset('storage/' . $item->file_materi) }}"
                                                                    alt="Image" class="w-full h-auto">
                                                            @elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                                <video controls class="w-full h-auto">
                                                                    <source
                                                                        src="{{ asset('storage/' . $item->file_materi) }}"
                                                                        type="video/{{ $fileExtension }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @elseif ($fileExtension === 'pdf')
                                                                <iframe
                                                                    src="{{ asset('storage/' . $item->file_materi) }}"
                                                                    class="w-full h-96" frameborder="0"></iframe>
                                                            @else
                                                                <p>Tipe file tidak di dukung.</p>
                                                            @endif
                                                        @else
                                                            <p>tidak ada lampiran.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="font-semibold capitalize">{{ $item->kategori->nama_kategori }}</td>
                                        @if (Auth::user()->role === 'admin')
                                            <td class="flex items-center gap-4">
                                                {{-- Modal Update --}}
                                                <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                    onclick="document.getElementById('update_materi_{{ $item->id_materi }}').showModal();" />

                                                <dialog id="update_materi_{{ $item->id_materi }}"
                                                    class="modal modal-bottom sm:modal-middle">
                                                    <div class="modal-box bg-neutral text-white">
                                                        <h3 class="text-lg font-bold">Update Materi</h3>
                                                        <div class="mt-3">
                                                            <form method="POST"
                                                                action="{{ route('edit_materi', $item->id_materi) }}"
                                                                enctype="multipart/form-data"
                                                                onsubmit="handleFileUpload(event, {{ $item->id_materi }})">
                                                                @csrf
                                                                @method('PUT')
                                                                @foreach (['kode_materi', 'nama_materi'] as $field)
                                                                    <div class="mb-4">
                                                                        <label
                                                                            for="{{ $field . '_' . $item->id_materi }}"
                                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                                        <input type="text"
                                                                            id="{{ $field . '_' . $item->id_materi }}"
                                                                            name="{{ $field }}"
                                                                            placeholder="Masukan {{ str_replace('_', ' ', $field) }}..."
                                                                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($field) border-red-500 @enderror"
                                                                            value="{{ old($field, $item->$field) }}" />
                                                                        @error($field)
                                                                            <span
                                                                                class="text-red-500 text-sm">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach

                                                                <!-- Kategori Select Box -->
                                                                <div class="mb-4">
                                                                    <label for="kategori_{{ $item->id_materi }}"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                                                                    <select id="kategori_{{ $item->id_materi }}"
                                                                        name="id_kategori"
                                                                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('id_kategori') border-red-500 @enderror">
                                                                        @forelse ($kategori as $k)
                                                                            <option value="{{ $k->id_kategori }}"
                                                                                {{ old('id_kategori', $item->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                                                                {{ $k->kode_kategori . '-' . $k->nama_kategori }}
                                                                            </option>
                                                                        @empty
                                                                            <option value="" disabled>Tidak ada
                                                                                kategori tersedia</option>
                                                                        @endforelse
                                                                    </select>
                                                                    @error('id_kategori')
                                                                        <span
                                                                            class="text-red-500 text-sm">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <!-- File Materi Input -->
                                                                <div class="mb-4">
                                                                    <label for="file_materi_{{ $item->id_materi }}"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File
                                                                        Materi</label>
                                                                    <input type="file"
                                                                        id="file_materi_{{ $item->id_materi }}"
                                                                        name="file_materi"
                                                                        accept="image/*,video/*,application/pdf"
                                                                        class="file-input w-full bg-gray-300 text-black"
                                                                        onchange="showFilePreview(event, {{ $item->id_materi }})" />
                                                                    @error('file_materi')
                                                                        <span
                                                                            class="text-red-500 text-sm">{{ $message }}</span>
                                                                    @enderror
                                                                    <div id="file_preview_{{ $item->id_materi }}"
                                                                        class="mt-2"></div>
                                                                </div>

                                                                <!-- Progress Bar and Percentage -->
                                                                <div class="mb-4">
                                                                    <progress
                                                                        id="upload_progress_{{ $item->id_materi }}"
                                                                        class="progress w-full" value="0"
                                                                        max="100"></progress>
                                                                    <span
                                                                        id="upload_progress_percent_{{ $item->id_materi }}"
                                                                        class="text-sm text-gray-900 dark:text-white ml-2">0%</span>
                                                                </div>

                                                                <div class="modal-action">
                                                                    <button type="button"
                                                                        onclick="document.getElementById('update_materi_{{ $item->id_materi }}').close()"
                                                                        class="btn">Batal</button>
                                                                    <button type="submit"
                                                                        id="submit_button_{{ $item->id_materi }}"
                                                                        class="btn btn-success">Simpan</button>
                                                                </div>
                                                            </form>

                                                            <script>
                                                                function showFilePreview(event, id) {
                                                                    const input = event.target;
                                                                    const previewContainer = document.getElementById('file_preview_' + id);
                                                                    previewContainer.innerHTML = '';

                                                                    if (input.files && input.files[0]) {
                                                                        const file = input.files[0];
                                                                        const fileType = file.type;
                                                                        let previewElement;

                                                                        if (fileType.startsWith('image/')) {
                                                                            previewElement = document.createElement('img');
                                                                            previewElement.src = URL.createObjectURL(file);
                                                                            previewElement.classList.add('rounded-lg', 'cursor-pointer');
                                                                        } else if (fileType.startsWith('video/')) {
                                                                            previewElement = document.createElement('video');
                                                                            previewElement.src = URL.createObjectURL(file);
                                                                            previewElement.controls = true;
                                                                            previewElement.classList.add('rounded-lg', 'cursor-pointer');
                                                                        } else if (fileType === 'application/pdf') {
                                                                            previewElement = document.createElement('embed');
                                                                            previewElement.src = URL.createObjectURL(file);
                                                                            previewElement.type = 'application/pdf';
                                                                            previewElement.width = '100%';
                                                                            previewElement.height = '500px';
                                                                            previewElement.classList.add('rounded-lg', 'cursor-pointer');
                                                                        }

                                                                        if (previewElement) {
                                                                            previewElement.onclick = function() {
                                                                                input.value = '';
                                                                                previewContainer.innerHTML = '';
                                                                            };
                                                                            previewContainer.appendChild(previewElement);
                                                                        }
                                                                    }
                                                                }

                                                                function handleFileUpload(event, id) {
                                                                    event.preventDefault();
                                                                    const form = event.target;
                                                                    const formData = new FormData(form);
                                                                    const xhr = new XMLHttpRequest();
                                                                    const progressBar = document.getElementById('upload_progress_' + id);
                                                                    const progressPercent = document.getElementById('upload_progress_percent_' + id);
                                                                    const submitButton = document.getElementById('submit_button_' + id);

                                                                    submitButton.disabled = true;

                                                                    xhr.open('POST', form.action, true);
                                                                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                                                                    xhr.upload.addEventListener('progress', function(e) {
                                                                        if (e.lengthComputable) {
                                                                            const percentComplete = (e.loaded / e.total) * 100;
                                                                            progressBar.value = percentComplete;
                                                                            progressPercent.textContent = Math.round(percentComplete) + '%';
                                                                        }
                                                                    });

                                                                    xhr.addEventListener('readystatechange', function() {
                                                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                                                            document.getElementById('update_materi_' + id).close();
                                                                            submitButton.disabled = false;
                                                                        }
                                                                    });

                                                                    xhr.send(formData);
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                </dialog>


                                                {{-- Hapus --}}
                                                <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                    onclick="document.getElementById('hapus_modal_{{ $item->id_materi }}').showModal();" />

                                                <dialog id="hapus_modal_{{ $item->id_materi }}"
                                                    class="modal modal-bottom sm:modal-middle">
                                                    <div class="modal-box bg-neutral text-white">
                                                        <h3 class="text-lg font-bold">Hapus
                                                            {{ $item->kode_materi . '-' . $item->nama_materi }}
                                                        </h3>
                                                        <div class="mt-3">
                                                            <p class="text-red-700 font-semibold">Perhatian! Anda
                                                                sedang
                                                                mencoba untuk menghapus materi
                                                                <strong
                                                                    class="text-red-800 font-bold">{{ $item->kode_materi . ' - ' . $item->nama_materi }}</strong>.
                                                                <span class="text-gray-600">Tindakan ini akan menghapus
                                                                    semua data terkait. Apakah Anda yakin ingin
                                                                    melanjutkan?</span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="document.getElementById('hapus_modal_{{ $item->id_materi }}').close()"
                                                                class="btn">Batal</button>
                                                            <form
                                                                action="{{ route('hapus_materi', $item->id_materi) }}"
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
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-base-300">Tidak ada materi tersedia
                                        </td>
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

<dialog id="tambah_materi_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-neutral text-white">
        <h3 class="text-lg font-bold">Tambah Materi</h3>
        <div class="mt-3">
            <form method="POST" action="{{ route('tambah_materi') }}" enctype="multipart/form-data"
                onsubmit="uploadFile(event)">
                @csrf
                <!-- Kode Materi Input -->
                <div class="mb-4">
                    <label for="kode_materi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode
                        Materi</label>
                    <input type="text" id="kode_materi" name="kode_materi" placeholder="Masukan kode materi..."
                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('kode_materi') border-red-500 @enderror"
                        value="{{ old('kode_materi') }}" />
                    @error('kode_materi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nama Materi Input -->
                <div class="mb-4">
                    <label for="nama_materi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Materi</label>
                    <input type="text" id="nama_materi" name="nama_materi" placeholder="Masukan nama materi..."
                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('nama_materi') border-red-500 @enderror"
                        value="{{ old('nama_materi') }}" />
                    @error('nama_materi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kategori Select Box -->
                <div class="mb-4">
                    <label for="id_kategori"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                    <select id="id_kategori" name="id_kategori"
                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error('id_kategori') border-red-500 @enderror">
                        @forelse ($kategori as $k)
                            <option value="{{ $k->id_kategori }}"
                                {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->kode_kategori . '-' . $k->nama_kategori }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada kategori tersedia</option>
                        @endforelse
                    </select>
                    @error('id_kategori')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- File Materi Input -->
                <div class="mb-4">
                    <label for="file_materi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File
                        Materi</label>
                    <input type="file" id="file_materi" name="file_materi"
                        accept="image/*,video/*,application/pdf" class="file-input w-full bg-gray-300 text-black"
                        onchange="previewFile(event)" />
                    @error('file_materi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <div id="preview_tambah" class="mt-2"></div>
                </div>

                <!-- Progress Bar and Percentage -->
                <div class="mb-4">
                    <progress id="progress_bar_tambah" class="progress w-full" value="0"
                        max="100"></progress>
                    <span id="progress_percent_tambah" class="text-sm text-gray-900 dark:text-white ml-2">0%</span>
                </div>

                <div class="modal-action">
                    <button type="button" onclick="document.getElementById('tambah_materi_modal').close()"
                        class="btn">Batal</button>
                    <button type="submit" id="submit_btn_tambah" class="btn btn-success">Simpan</button>
                </div>
            </form>

            <script>
                function previewFile(event) {
                    const input = event.target;
                    const previewContainer = document.getElementById('preview_tambah');
                    previewContainer.innerHTML = '';

                    if (input.files && input.files[0]) {
                        const file = input.files[0];
                        const fileType = file.type;
                        let previewElement;

                        if (fileType.startsWith('image/')) {
                            previewElement = document.createElement('img');
                            previewElement.src = URL.createObjectURL(file);
                            previewElement.classList.add('rounded-lg', 'cursor-pointer');
                        } else if (fileType.startsWith('video/')) {
                            previewElement = document.createElement('video');
                            previewElement.src = URL.createObjectURL(file);
                            previewElement.controls = true;
                            previewElement.classList.add('rounded-lg', 'cursor-pointer');
                        } else if (fileType === 'application/pdf') {
                            previewElement = document.createElement('embed');
                            previewElement.src = URL.createObjectURL(file);
                            previewElement.type = 'application/pdf';
                            previewElement.width = '100%';
                            previewElement.height = '500px';
                            previewElement.classList.add('rounded-lg', 'cursor-pointer');
                        }

                        if (previewElement) {
                            previewElement.onclick = function() {
                                input.value = '';
                                previewContainer.innerHTML = '';
                            };
                            previewContainer.appendChild(previewElement);
                        }
                    }
                }

                function uploadFile(event) {
                    event.preventDefault();
                    const form = event.target;
                    const formData = new FormData(form);
                    const xhr = new XMLHttpRequest();
                    const progressBar = document.getElementById('progress_bar_tambah');
                    const progressPercent = document.getElementById('progress_percent_tambah');
                    const submitButton = document.getElementById('submit_btn_tambah');

                    submitButton.disabled = true;

                    xhr.open('POST', form.action, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            const percentComplete = (e.loaded / e.total) * 100;
                            progressBar.value = percentComplete;
                            progressPercent.textContent = Math.round(percentComplete) + '%';
                        }
                    });

                    xhr.addEventListener('readystatechange', function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            document.getElementById('tambah_materi_modal').close();
                            submitButton.disabled = false;
                        }
                    });

                    xhr.send(formData);
                }
            </script>
        </div>
    </div>
</dialog>