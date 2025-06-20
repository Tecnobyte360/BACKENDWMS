<div class="p-10 bg-gradient-to-br from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl space-y-12">
    <form class="space-y-12" wire:submit.prevent="guardar">
        <section class="p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-xl space-y-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white border-b pb-2">Configuración conexión SAP</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    'base_url' => 'Base URL',
                    'company_db' => 'Base de Datos',
                    'username' => 'Usuario',
                    'password' => 'Contraseña',
                    'route_id' => 'ID de Ruta'
                ] as $campo => $etiqueta)
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">{{ $etiqueta }} *</label>
                        <input
                            type="{{ $campo === 'password' ? 'password' : 'text' }}"
                            wire:model.lazy="{{ $campo }}"
                            class="w-full px-4 py-3 pr-10 rounded-2xl border transition-all shadow-inner
                            @error($campo) border-red-500 focus:border-red-500 focus:ring-red-300
                            @elseif(!empty($$campo)) border-green-500 focus:border-green-500 focus:ring-green-300
                            @else border-gray-300 focus:border-violet-500 focus:ring-violet-300 @enderror
                            dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4"
                        />
                        @if(!empty($$campo) && !$errors->has($campo))
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            </div>
                        @endif
                        @error($campo)
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="pt-6">
                <button type="submit"
                    wire:loading.attr="disabled"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-xl transition"
                    @if(!$cambios) disabled class="opacity-50 cursor-not-allowed" @endif
                >
                    <i class="fas fa-sync-alt animate-pulse"></i>
                    {{ $configId ? 'Actualizar Configuración' : 'Guardar Configuración' }}
                </button>
            </div>
        </section>
    </form>

    {{-- Loading --}}
   {{-- Pantalla de carga con estilo glassmorphism y animaciones --}}
<div wire:loading wire:target="guardar" class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-transparent backdrop-blur-md animate-fadeIn">

    <!-- Contenedor principal centrado -->
    <div class="max-w-md w-auto mx-auto px-6 flex flex-col items-center justify-center relative translate-y-10">

        <!-- Caja visual con efecto glass y shimmer -->
        <div class="w-full bg-white/30 dark:bg-gray-800/30 backdrop-blur-lg border border-violet-300 dark:border-violet-700 rounded-3xl shadow-xl p-10 space-y-8 text-center relative overflow-hidden">

            <!-- Efecto shimmer animado -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>

            <!-- Spinner decorativo -->
            <div class="w-20 h-20 mx-auto relative z-10">
                <div class="w-full h-full border-4 border-violet-400 border-t-transparent rounded-full animate-spin"></div>
            </div>

            <!-- Icono central -->
            <div class="flex justify-center z-10">
                <i class="fas fa-cogs text-6xl text-violet-600 dark:text-violet-300 animate-bounce drop-shadow-md"></i>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white tracking-tight animate-pulse z-10">
                Actualizando configuración SAP
            </h2>

            <!-- Subtítulo -->
            <p class="text-base text-gray-600 dark:text-gray-400 font-medium z-10">
                Por favor espera mientras se guarda la información...
            </p>

            <!-- Barra de progreso animada -->
            <div class="w-full h-2 rounded-full bg-violet-200 dark:bg-violet-800 overflow-hidden relative z-10">
                <div class="absolute top-0 left-0 h-full w-1/2 bg-gradient-to-r from-violet-500 to-violet-400 animate-marquee"></div>
            </div>
        </div>
    </div>
</div>

</div>
