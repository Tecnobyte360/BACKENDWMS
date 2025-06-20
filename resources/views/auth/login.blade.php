<x-authentication-layout>
    <!-- Encabezado -->
    <div class="flex flex-col items-center text-center mb-8 fade-up">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#132742] dark:text-[#F6EFEA] tracking-wide">
            Bienvenido a <span class="text-[#E56830]">Lolocal</span>
        </h1>
        <p class="text-sm md:text-base text-gray-600 dark:text-gray-300 mt-2 italic">
            Encuentra lo que necesites, donde estés.
        </p>
    </div>

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}"
        class="bg-[#F6EFEA] dark:bg-[#1a1a1a] border border-[#E56830]/30 dark:border-[#E56830]/50 rounded-2xl shadow-xl p-8 space-y-6 w-full max-w-md mx-auto">
        @csrf

        <div>
            <x-label for="email" value="Correo Electrónico" class="text-sm font-semibold text-[#132742] dark:text-[#F6EFEA]" />
            <x-input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 focus:border-[#E56830] focus:ring-[#E56830]" />
        </div>

        <div>
            <x-label for="password" value="Contraseña" class="text-sm font-semibold text-[#132742] dark:text-[#F6EFEA]" />
            <x-input id="password" type="password" name="password" required
                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 focus:border-[#E56830] focus:ring-[#E56830]" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 dark:border-gray-600 text-[#E56830] shadow-sm focus:ring-[#E56830]" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
            </label>
            <a class="text-sm text-[#E56830] hover:underline" href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <div>
            <button type="submit"
                class="w-full bg-[#E56830] hover:bg-[#d4551c] text-white font-bold py-2 px-4 rounded-lg shadow transition duration-300">
                Iniciar Sesión
            </button>
        </div>
    </form>

    <!-- Estilo animación -->
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.8s ease-out forwards; }
    </style>
</x-authentication-layout>
