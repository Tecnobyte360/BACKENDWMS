<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lolocal') }}</title>

    <link rel="icon" type="image/png" href="https://imagenes.20minutos.es/files/image_990_556/uploads/imagenes/2020/10/15/todos-los-mensajes-y-llamadas-de-whatsapp-estan-cifrados-de-extremo-a-extremo.jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Modo oscuro -->
    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>
</head>

<body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 overflow-hidden h-screen">

    <main class="relative bg-white dark:bg-gray-900 h-full flex flex-col overflow-hidden">

        <!-- SVG Superior -->
        <div class="relative w-full h-[100px] shrink-0 overflow-hidden">
            <svg class="w-full h-full" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#E56830" fill-opacity="1" d="M0,128L1440,32L1440,0L0,0Z" />
                <path fill="#132742" fill-opacity="1" d="M0,0L1440,160L1440,0L0,0Z" />
            </svg>
        </div>

        <!-- Contenido principal -->
        <div class="flex-grow flex flex-col md:flex-row overflow-hidden">
    <!-- Panel izquierdo -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-4 py-6 z-10">
        <div class="w-full max-w-sm mx-auto">
            {{ $slot }}
        </div>
    </div>

    <!-- Panel derecho con degradado de 3 colores -->
 <div class="hidden md:flex flex-col justify-center items-center md:w-1/2 bg-gradient-to-r from-[#E56830] via-[#F6EFEA] to-[#F6EFEA] p-6">
    <div class="rounded-3xl backdrop-blur-md bg-white/30 shadow-2xl p-3 transition-transform duration-500 hover:scale-105 animate-float">
        <img src="{{ asset('images/lolo.jpeg') }}" alt="Authentication image"
            class="w-[20rem] h-auto rounded-2xl" />
    </div>
</div>


</div>
<STYLE>
@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-8px);
  }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}
</STYLE>

        <!-- SVG Inferior -->
        <div class="relative w-full h-[100px] shrink-0 overflow-hidden">
            <svg class="w-full h-full rotate-180" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#E56830" fill-opacity="1" d="M0,128L1440,32L1440,0L0,0Z" />
                <path fill="#132742" fill-opacity="1" d="M0,0L1440,160L1440,0L0,0Z" />
            </svg>
        </div>

    </main>

    @livewireScripts
</body>

</html>
