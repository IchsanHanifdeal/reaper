<div class="drawer-side border-r z-20">
    <label for="aside-dashboard" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul
        class="bg-[#ffeef6] menu flex flex-col justify-between p-4 w-64 lg:w-72 min-h-full bg-white [&>li>a]:gap-4 [&>li]:my-1.5 [&>li]:text-[14.3px] [&>li]:font-medium [&>li]:text-opacity-80 [&>li]:text-base [&>_*_svg]:stroke-[1.5] [&>_*_svg]:size-[23px]">
        <div>
            <div class="pb-4 border-b border-gray-300">
                @include('components.brands', ['class' => 'btn btn-ghost text-2xl'])
            </div>            
            <span class="label text-xs font-extrabold opacity-50">GENERAL</span>
            <li>
                <a href="{{ route('dashboard') }}" class="{!! Request::path() == 'dashboard' ? 'active' : '' !!} flex items-center px-2.5">
                    <x-lucide-bar-chart-2 />
                    Dashboard
                </a>
            </li>
            @if (Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('peserta') }}" class="{!! preg_match('#^dashboard/peserta.*#', Request::path()) ? 'active' : '' !!} flex items-center px-2.5">
                        <x-lucide-tag />
                        Kelola Peserta
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('kategori') }}" class="{!! preg_match('#^dashboard/kategori.*#', Request::path()) ? 'active' : '' !!} flex items-center px-2.5">
                    <x-lucide-tag />
                    @if (Auth::user()->role === 'admin')
                        Kelola
                    @endif Kategori
                </a>
            </li>
            <li>
                <a href="{{ route('materi') }}" class="{!! preg_match('#^dashboard/materi.*#', Request::path()) ? 'active' : '' !!} flex items-center px-2.5">
                    <x-lucide-tag />
                    @if (Auth::user()->role === 'admin')
                        Kelola
                    @endif Materi
                </a>
            </li>
        </div>
        <div class="flex flex-col">
            <span class="label text-xs font-extrabold opacity-50">ADVANCE</span>
            <li>
                <a href="{{ route('profile') }}" class="{!! Request::path() == 'dashboard/profile' ? 'active' : '' !!} flex items-center px-2.5">
                    <x-lucide-user-2 />
                    Profile
                </a>
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="px-0">
                    @csrf
                    <a class="flex items-center px-2.5 gap-4" href="#"
                        onclick="event.preventDefault(); confirmLogout();">
                        <x-lucide-log-out />
                        Logout
                    </a>
                </form>
            </li>
        </div>
    </ul>
</div>
