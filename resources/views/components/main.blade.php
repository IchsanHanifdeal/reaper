<!DOCTYPE html>
<html lang="en" data-theme="pastel">

<head>
    @include('components.head')
    <style>
        .toast {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .toast-show {
            opacity: 1;
        }
    </style>

</head>

<body class="flex flex-col mx-auto min-h-screen">
    <div id="splash-screen"
        class="fixed inset-0 flex items-center justify-center bg-white/90 z-[9999] transition-opacity duration-500">
        <div class="p-6 bg-white rounded-lg shadow-lg flex items-center justify-center flex-col">
            <div class="animate-spin h-12 w-12 border-t-4 border-blue-500 rounded-full mb-4"></div>
            <div>
                @include('components.brands')
            </div>
        </div>
    </div>
    <main class="{{ $class ?? 'p-4' }}" role="main">
        {{ $slot }}

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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var splashScreen = document.getElementById('splash-screen');

                splashScreen.classList.add('show');

                window.addEventListener('load', function() {
                    splashScreen.classList.remove('show');
                });
            });

            window.addEventListener('beforeunload', function() {
                var splashScreen = document.getElementById('splash-screen');
                splashScreen.classList.add('show');
            });
        </script>
    </main>
</body>

</html>
