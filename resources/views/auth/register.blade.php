@php
    $fields = [
        'nik' => [
            'type' => 'string',
            'label' => 'Nik/Sap',
            'placeholder' => 'Masukan Nik/Sap...',
        ],
        'nama' => [
            'type' => 'text',
            'label' => 'Nama',
            'placeholder' => 'Masukan nama...',
        ],
        'tempat_lahir' => [
            'type' => 'text',
            'label' => 'Tempat Lahir',
            'placeholder' => 'Masukan tempat lahir...',
        ],
        'tanggal_lahir' => [
            'type' => 'date',
            'label' => 'Tanggal Lahir',
            'placeholder' => 'Masukan tanggal lahir...',
        ],
        'alamat' => [
            'type' => 'text',
            'label' => 'Alamat',
            'placeholder' => 'Masukan alamat...',
        ],
        'no_hp' => [
            'type' => 'number',
            'label' => 'Nomor Handphone',
            'placeholder' => 'Masukan No Handphone...',
        ],
        'email' => [
            'type' => 'email',
            'label' => 'Alamat Email',
            'placeholder' => 'Masukan No Handphone...',
        ],
        'password' => [
            'type' => 'number',
            'label' => 'Password',
            'placeholder' => 'Masukan password...',
        ],
    ];
@endphp

<x-main title="Registrasi">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold">
            <x-lucide-award class="w-8 h-8 mr-2" alt="logo" /> Reaper
        </a>
        <div class="w-full bg-neutral rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center uppercase">
                    Pendaftaran Peserta
                </h1>
                <form class="space-y-4 md:space-y-6" action="{{ route('store.peserta') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($fields as $field => $attributes)
                            <div>
                                <label for="{{ $field }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $attributes['label'] }}
                                    :</label>
                                <input type="{{ $attributes['type'] }}" name="{{ $field }}"
                                    id="{{ $field }}"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="{{ $attributes['placeholder'] }}" required>
                                @error($field)
                                    <span class="validated text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <button type="submit"
                        class="w-full bg-primary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center font-bold">Daftar</button>
                    <a href="{{ route('index') }}"
                        class="btn w-full bg-secondary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</x-main>
