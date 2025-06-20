<div>

<div class="p-10 bg-gradient-to-br from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl space-y-12">



    <!-- Formulario -->
<form class="space-y-12" wire:submit.prevent="enviarEvaluacionASAP">

      

        <!-- Información General -->
       <section class="p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-xl space-y-10">

            {{-- Título --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white border-b pb-2">Información General</h2>
           

            {{-- Grid Principal con Alpine --}}
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8"
                x-data="{
                    searchCentro: '',
                    openCentro: false,
                    searchProv: '',
                    openProv: false
                }"
                x-init="
                    $watch('searchCentro', value => {
                        if (value === '') {
                            $wire.set('centro_costo_id', '');
                            $wire.set('proveedor_id', '');
                            searchProv = '';
                        }
                    });

                    Livewire.on('resetCamposBusqueda', () => {
                        searchCentro = '';
                        searchProv = '';
                    });
                "
            >


                {{-- Fecha de Inicio (solo lectura) --}}
                <div class="relative">
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Fecha Desde</label>
                  {{-- Fecha Inicio --}}
                    <input type="date" wire:model="fecha_inicio"
                        @if($cuatrimestre) readonly @endif
                        class="w-full px-4 py-3 pr-10 rounded-2xl border shadow-inner
                        {{ $cuatrimestre ? 'cursor-not-allowed text-gray-400 bg-gray-100 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}
                        border-gray-300 dark:border-gray-700 dark:text-white focus:ring-4 focus:ring-violet-300" disabled/>

                </div>

                {{-- Fecha Final (activa consulta SAP) --}}
               {{-- Fecha Final (activa consulta SAP o bloqueada si hay cuatrimestre) --}}
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Fecha Hasta *</label>

                <input type="date"
                    wire:model.lazy="fecha_fin"
                    @if($cuatrimestre) readonly @endif
                    class="w-full px-4 py-3 pr-10 rounded-2xl border transition-all shadow-inner
                    @error('fecha_fin') border-red-500 focus:ring-red-300 focus:border-red-500
                    @else border-gray-300 focus:ring-violet-300 focus:border-violet-500 @enderror
                    {{ $cuatrimestre ? 'cursor-not-allowed text-gray-400 bg-gray-100 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}
                    dark:border-gray-700 dark:text-white focus:ring-4" disabled/>

                {{-- Ícono de validación si es válido --}}
                @if(!empty($fecha_fin) && !$errors->has('fecha_fin'))
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    </div>
                @endif

                {{-- Mensaje de error --}}
                @error('fecha_fin')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

                  



                {{-- Cuatrimestre --}}
                <div class="relative">
                        <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Cuatrimestre *</label>
                        <select wire:model.lazy="cuatrimestre"
                            class="w-full px-4 py-3 rounded-2xl border transition-all shadow-inner
                            @error('cuatrimestre') border-red-500 focus:ring-red-300 focus:border-red-500
                            @else border-gray-300 focus:ring-red-300 focus:border-red-500 @enderror
                            dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4">
                            <option value="">Selecciona un cuatrimestre</option>
                            @foreach($cuatrimestres as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>

                        @if(!empty($cuatrimestre) && !$errors->has('cuatrimestre'))
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            </div>
                        @endif

                        @error('cuatrimestre') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>


                {{-- Fecha Evaluación --}}
                <div class="relative">
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Fecha Evaluación *</label>
                  <input wire:model.lazy="fecha_evaluacion" type="date"
                        class="w-full px-4 py-3 pr-10 rounded-2xl border transition-all shadow-inner
                        @error('fecha_evaluacion') border-red-500 focus:ring-red-300 focus:border-red-500
                        @elseif(!empty($fecha_evaluacion)) border-green-500 focus:ring-green-300 focus:border-green-500
                        @else border-gray-300 focus:ring-violet-300 focus:border-violet-500 @enderror
                        dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4" disabled
                    />

                                    @if(!empty($fecha_evaluacion) && !$errors->has('fecha_evaluacion'))
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        </div>
                    @endif

                    @error('fecha_evaluacion') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Centro de Costos --}}
                            <div class="relative col-span-2" @click.away="openCentro = false">
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Centro de Costos *</label>
                    
                    <input type="text"
                        x-model="searchCentro" @focus="openCentro = true"
                        placeholder="Escribe el código del centro de costos"
                        class="w-full px-4 py-3 pr-10 rounded-2xl border transition-all shadow-inner
                            @error('centro_costo_id') border-red-500 ring-red-300 focus:border-red-500 focus:ring-red-300
                            @elseif(!empty($centro_costo_id)) border-green-500 ring-green-300 focus:border-green-500 focus:ring-green-300
                            @else border-gray-300 focus:border-violet-500 focus:ring-violet-300 @enderror
                            dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4"
                    />

                    {{-- Ícono verde si es válido --}}
                    @if(!empty($centro_costo_id) && !$errors->has('centro_costo_id'))
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        </div>
                    @endif

                    {{-- Lista desplegable --}}
                    <ul x-show="openCentro"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 rounded-xl border border-gray-300 dark:border-gray-700 shadow-lg max-h-60 overflow-auto">
                        @foreach($centrosCostos as $centro)
                            <li
                                x-show="searchCentro === '' || '{{ strtolower($centro['codigo']) }}'.includes(searchCentro.toLowerCase())"
                                @click="$wire.set('centro_costo_id', '{{ $centro['codigo'] }}'); searchCentro = '{{ $centro['codigo'] }}'; openCentro = false"
                                class="px-4 py-2 hover:bg-violet-100 dark:hover:bg-violet-600 cursor-pointer">
                                {{ $centro['codigo'] }}
                            </li>
                        @endforeach
                    </ul>

                    {{-- Mensaje de error --}}
                    @error('centro_costo_id')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

              <!-- Proveedor -->
                <div class="relative md:col-span-1" @click.away="openProv = false">
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Proveedor *</label>

                    <input type="text"
                        x-model="searchProv" @focus="openProv = true"
                        placeholder="Escribe para buscar proveedor"
                        class="w-full px-4 py-3 pr-10 rounded-2xl border transition-all shadow-inner
                            @error('proveedor_id') border-red-500 ring-red-300 focus:border-red-500 focus:ring-red-300
                            @elseif(!empty($proveedor_id)) border-green-500 ring-green-300 focus:border-green-500 focus:ring-green-300
                            @else border-gray-300 focus:border-violet-500 focus:ring-violet-300 @enderror
                            dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4"
                    />

                    {{-- Ícono verde si es válido --}}
                    @if(!empty($proveedor_id) && !$errors->has('proveedor_id'))
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        </div>
                    @endif

                    {{-- Lista desplegable --}}
                    <ul x-show="openProv"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 rounded-xl border border-gray-300 dark:border-gray-700 shadow-lg max-h-60 overflow-auto">
                        @foreach($proveedoresFiltrados as $prov)
                            <li
                                x-show="searchProv === '' || '{{ strtolower($prov['nombre']) }}'.includes(searchProv.toLowerCase())"
                                @click="$wire.set('proveedor_id', '{{ $prov['codigo'] }}'); searchProv = '{{ $prov['nombre'] }}'; openProv = false"
                                class="px-4 py-2 hover:bg-violet-100 dark:hover:bg-violet-600 cursor-pointer">
                                {{ $prov['nombre'] }}
                            </li>
                        @endforeach
                    </ul>

                    {{-- Mensaje de error --}}
                    @error('proveedor_id')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Evaluador -->
                <div class="relative md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Evaluador</label>
                    
                    <div class="relative">
                        <!-- Icono de usuario -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 0112 15a4 4 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <!-- Input deshabilitado -->
                        <input 
                            type="text" 
                            value="{{ auth()->user()->name }}" 
                            disabled
                            class="w-full pl-10 pr-4 py-3 rounded-2xl border border-gray-300 dark:border-gray-700 dark:bg-gray-700 text-gray-400 cursor-not-allowed shadow-inner"
                        />
                    </div>
                </div>
            </div>


          <div class="col-span-2 md:col-span-1">
                <div class="space-y-4">
                    <!-- Encabezado -->
                   <div class="flex items-center justify-between bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-white px-5 py-4 rounded-2xl shadow-lg">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-clipboard-list text-2xl text-gray-600 dark:text-gray-300 drop-shadow-md"></i>
                            <h3 class="text-xl font-bold tracking-wide">Órdenes compra SAP</h3>
                        </div>
                        <span class="text-sm font-light italic text-gray-500 dark:text-gray-400">Consulta directa</span>
                    </div>


                    <!-- Tabla de órdenes -->
                    <div class="overflow-auto rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 bg-gradient-to-br from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                       <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                            <thead class="bg-violet-100 dark:bg-violet-700 text-violet-800 dark:text-white text-left">
                                <tr class="text-gray-500 dark:text-gray-300 uppercase text-xs tracking-wider">
                                    <th class="px-5 py-3 font-semibold">✔</th>
                                    <th class="px-5 py-3 font-semibold"><i class="fas fa-file-alt mr-1"></i># Orden</th>
                                    <th class="px-5 py-3 font-semibold"><i class="fas fa-user-tag mr-1"></i>Proveedor</th>
                                    <th class="px-5 py-3 font-semibold"><i class="fas fa-dollar-sign mr-1"></i>Total</th>
                                    <th class="px-5 py-3 font-semibold"><i class="fas fa-comment-dots mr-1"></i>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($ordenesCompra as $orden)
                                    <tr class="hover:bg-violet-50 dark:hover:bg-gray-800 transition duration-200">
                                        <td class="px-5 py-3 text-center text-gray-900 dark:text-white font-semibold">
                                            <input type="checkbox" wire:model="ordenesSeleccionadas" value="{{ $orden->id }}"
                                                class="form-checkbox h-5 w-5 text-violet-600 rounded focus:ring-2 focus:ring-violet-400 transition" disabled>
                                        </td>
                                        <td class="px-5 py-3 font-bold text-black-700 dark:text-violet-400 whitespace-nowrap">
                                            #{{ $orden->numero_orden_compra_sap }}
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap">
                                            {{ $orden->card_name }}
                                        </td>
                                        <td class="px-5 py-3 font-bold text-green-600 dark:text-green-400 whitespace-nowrap">
                                            ${{ number_format($orden->monto_total, 0) }}
                                        </td>
                                        <td class="px-5 py-3 italic text-gray-500 dark:text-gray-400">
                                            {{ $orden->comentarios ?? 'Sin comentarios' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No hay órdenes disponibles para este proveedor.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


             <section class="p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-xl space-y-4">
                        <div class="col-span-4 space-y-4">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Criterios de Evaluación</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                                @foreach([
                                    'cumplimiento_entrega' => 'Entrega',
                                    'calidad_servicio' => 'Calidad',
                                    'garantia_soporte' => 'Garantía',
                                    'precio' => 'Precio',
                                    'capacidad_respuesta' => 'Respuesta'
                                ] as $campo => $etiqueta)
                                    <div class="relative">
                                        <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">{{ $etiqueta }} *</label>
                                        <input wire:model.lazy="criterios.{{ $campo }}" type="number" min="1" max="10" step="1"
                                            class="w-full px-4 py-2 pr-10 rounded-xl border transition-all shadow-inner
                                            @error('criterios.' . $campo) border-red-500 focus:border-red-500 focus:ring-red-300
                                            @else border-gray-300 focus:border-red-500 focus:ring-red-300 @enderror
                                            dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4"/>
                                        @if(!empty($criterios[$campo]) && !$errors->has('criterios.' . $campo))
                                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                            </div>
                                        @endif
                                        @error('criterios.' . $campo)
                                        <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Observaciones</h2>
                    <div class="relative">
                        <textarea wire:model.lazy="observaciones" rows="4"
                            class="w-full px-4 py-3 pr-10 rounded-2xl border transition-all shadow-inner
                            @error('observaciones')
                                border-red-500 focus:border-red-500 focus:ring-red-300
                            @else
                                border-gray-300 focus:border-red-500 focus:ring-red-300
                            @enderror
                            dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-4"
                            placeholder="Escribe observaciones adicionales..."></textarea>
                        @if(!empty($observaciones) && !$errors->has('observaciones'))
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            </div>
                        @endif
                        @error('observaciones')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                 <div class="pt-10">
      <button type="submit"
    wire:loading.attr="disabled"
    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-xl transition">
    <i class="fas fa-paper-plane animate-pulse"></i> Enviar Evaluación a SAP
</button>


    </div>
            </section>
        
        </section>
   
    </form>


     </div>
   <!-- Contenedor de la pantalla de carga -->
        <div wire:loading wire:target="fecha_fin,cuatrimestre"
            class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-transparent backdrop-blur-md animate-fadeIn">

        <!-- Contenedor interno con desplazamiento hacia abajo -->
        <div class="max-w-md w-auto mx-auto px-6 flex flex-col items-center justify-center relative translate-y-10">

            <!-- Caja de carga con efecto glassmorphism y brillo animado -->
            <div class="w-full bg-white/30 dark:bg-gray-800/30 backdrop-blur-lg border border-violet-300 dark:border-violet-700 rounded-3xl shadow-xl p-10 space-y-8 text-center relative overflow-hidden">

            <!-- Efecto de brillo animado -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>

            <!-- Spinner decorativo -->
            <div class="w-20 h-20 mx-auto relative z-10">
                <div class="w-full h-full border-4 border-violet-400 border-t-transparent rounded-full animate-spin"></div>
            </div>

            <!-- Icono -->
            <div class="flex justify-center z-10">
                <i class="fas fa-cloud-download-alt text-6xl text-violet-600 dark:text-violet-300 animate-bounce drop-shadow-md"></i>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white tracking-tight animate-pulse z-10">
                Conectando con SAP
            </h2>

            <!-- Subtítulo -->
            <p class="text-base text-gray-600 dark:text-gray-400 font-medium z-10">
                Consultando órdenes de compra...
            </p>

            <!-- Barra de progreso con animación de deslizamiento -->
            <div class="w-full h-2 rounded-full bg-violet-200 dark:bg-violet-800 overflow-hidden relative z-10">
                <div class="absolute top-0 left-0 h-full w-1/2 bg-gradient-to-r from-violet-500 to-violet-400 animate-marquee"></div>
            </div>
            </div>
        </div>
        </div>

<div wire:loading wire:target="enviarEvaluacionASAP" c class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-transparent backdrop-blur-md animate-fadeIn">

        <!-- Contenedor interno con desplazamiento hacia abajo -->
        <div class="max-w-md w-auto mx-auto px-6 flex flex-col items-center justify-center relative translate-y-10">

            <!-- Caja de carga con efecto glassmorphism y brillo animado -->
            <div class="w-full bg-white/30 dark:bg-gray-800/30 backdrop-blur-lg border border-violet-300 dark:border-violet-700 rounded-3xl shadow-xl p-10 space-y-8 text-center relative overflow-hidden">

            <!-- Efecto de brillo animado -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>

            <!-- Spinner decorativo -->
            <div class="w-20 h-20 mx-auto relative z-10">
                <div class="w-full h-full border-4 border-violet-400 border-t-transparent rounded-full animate-spin"></div>
            </div>

            <!-- Icono -->
            <div class="flex justify-center z-10">
                <i class="fas fa-cloud-download-alt text-6xl text-violet-600 dark:text-violet-300 animate-bounce drop-shadow-md"></i>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white tracking-tight animate-pulse z-10">
                Conectando con SAP
            </h2>

            <!-- Subtítulo -->
            <p class="text-base text-gray-600 dark:text-gray-400 font-medium z-10">
               Enviando evaluacion SAP...
            </p>

            <!-- Barra de progreso con animación de deslizamiento -->
            <div class="w-full h-2 rounded-full bg-violet-200 dark:bg-violet-800 overflow-hidden relative z-10">
                <div class="absolute top-0 left-0 h-full w-1/2 bg-gradient-to-r from-violet-500 to-violet-400 animate-marquee"></div>
            </div>
            </div>
        </div>
        </div>
   
</div>

</div>




