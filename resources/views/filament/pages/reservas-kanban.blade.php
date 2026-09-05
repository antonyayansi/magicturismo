<x-filament-panels::page>
    <div
        class="flex gap-4 overflow-x-auto pb-4"
        style="min-height: 28rem;"
    >
        @foreach ($estados as $estado)
            @php
                $items = $reservasPorEstado->get($estado->clave, collect());
            @endphp
            <section
                wire:key="col-{{ $estado->clave }}"
                class="flex w-80 shrink-0 flex-col rounded-xl bg-gray-50 dark:bg-gray-900/40 ring-1 ring-gray-950/5 dark:ring-white/10"
                x-data
                @dragover.prevent
                @drop.prevent="$wire.mover(Number($event.dataTransfer.getData('reserva')), @js($estado->clave))"
            >
                <header class="flex items-center justify-between gap-2 px-3 py-3">
                    <div class="flex items-center gap-2 min-w-0">
                        <span @class([
                            'inline-block h-2.5 w-2.5 rounded-full',
                            'bg-warning-500' => $estado->color === 'warning',
                            'bg-success-500' => $estado->color === 'success',
                            'bg-info-500' => $estado->color === 'info',
                            'bg-primary-500' => $estado->color === 'primary',
                            'bg-danger-500' => $estado->color === 'danger',
                            'bg-gray-400' => ! in_array($estado->color, ['warning', 'success', 'info', 'primary', 'danger'], true),
                        ])></span>
                        <h3 class="truncate text-sm font-semibold text-gray-950 dark:text-white">
                            {{ $estado->nombre }}
                        </h3>
                    </div>
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-gray-950/5 dark:bg-white/5 dark:text-gray-300 dark:ring-white/10">
                        {{ $items->count() }}
                    </span>
                </header>

                <div class="flex flex-1 flex-col gap-2 px-2 pb-3 min-h-[12rem]">
                    @forelse ($items as $reserva)
                        <article
                            wire:key="card-{{ $reserva->id }}"
                            draggable="true"
                            @dragstart="$event.dataTransfer.setData('reserva', '{{ $reserva->id }}')"
                            class="cursor-grab rounded-lg bg-white p-3 shadow-sm ring-1 ring-gray-950/5 transition hover:ring-primary-400 dark:bg-gray-800 dark:ring-white/10"
                        >
                            <a
                                href="{{ \App\Filament\Resources\ReservasResource::getUrl('edit', ['record' => $reserva]) }}"
                                class="block"
                                @mousedown.stop
                            >
                                <p class="text-sm font-semibold text-gray-950 dark:text-white">
                                    {{ $reserva->cliente }}
                                </p>
                                <p class="mt-0.5 truncate text-xs text-gray-500 dark:text-gray-400">
                                    {{ $reserva->paquete?->titulo ?: 'Sin experiencia' }}
                                </p>
                                <div class="mt-2 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $reserva->cantidad_personas }} pers.</span>
                                    <span>
                                        {{ $reserva->fecha_reserva ? \Illuminate\Support\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') : '—' }}
                                    </span>
                                </div>
                            </a>
                        </article>
                    @empty
                        <p class="px-2 py-6 text-center text-xs text-gray-400">
                            Suelta aquí una reserva
                        </p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-filament-panels::page>
