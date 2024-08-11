<x-main title="Pilih">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="{{ route('index') }}" class="flex items-center mb-6 text-2xl font-semibold">
            <x-lucide-award class="w-8 h-8 mr-2" alt="logo" /> Reaper
        </a>
        <div class="w-full bg-neutral rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center uppercase">
                    Sistem Informasi Registrasi Pelatihan Peserta
                </h1>
                <div class="flex flex-col items-center justify-center space-y-4">
                    <a href="{{ route('login')}}" class="btn w-full max-w-xs bg-primary hover:bg-base-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center transition duration-300 ease-in-out transform hover:scale-105">Masuk</a>
                    <a href="{{ route('register')}}" class="btn w-full max-w-xs bg-base-100 hover:bg-primary focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2.5 text-center transition duration-300 ease-in-out transform hover:scale-105">Daftar</a>
                </div>                
            </div>
        </div>
    </div>
</x-main>
