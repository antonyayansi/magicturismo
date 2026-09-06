<x-filament-panels::page>
    <div
        x-data="{
            dragging: null,
            over: null,
            start(event, id) {
                this.dragging = String(id);
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('reserva', String(id));

                const card = event.currentTarget;
                const ghost = card.cloneNode(true);
                ghost.querySelectorAll('a').forEach((link) => link.removeAttribute('href'));
                ghost.style.width = card.offsetWidth + 'px';
                ghost.style.position = 'absolute';
                ghost.style.top = '-1000px';
                ghost.style.left = '-1000px';
                ghost.style.transform = 'rotate(3deg) scale(1.03)';
                ghost.style.boxShadow = '0 16px 30px rgba(15, 23, 42, 0.22)';
                ghost.style.opacity = '1';
                document.body.appendChild(ghost);
                event.dataTransfer.setDragImage(ghost, Math.min(event.offsetX, 80), 20);
                setTimeout(() => ghost.remove(), 50);
            },
            enter(clave) {
                this.over = clave;
            },
            leave(event, clave) {
                if (! event.currentTarget.contains(event.relatedTarget)) {
                    if (this.over === clave) {
                        this.over = null;
                    }
                }
            },
            async drop(event, clave) {
                const id = Number(event.dataTransfer.getData('reserva') || this.dragging);
                this.over = null;
                this.dragging = null;
                if (! id) {
                    return;
                }
                await $wire.mover(id, clave);
            },
            end() {
                this.dragging = null;
                this.over = null;
            }
        }"
        @dragend="end()"
        class="relative flex gap-4 overflow-x-auto pb-4"
        style="min-height: 28rem;"
    >
        <div
            wire:loading.flex
            wire:target="mover"
            class="absolute inset-0 z-20 hidden items-start justify-center rounded-xl bg-white/55 pt-24 text-sm font-medium text-gray-600 backdrop-blur-[1px] dark:bg-gray-950/40 dark:text-gray-200"
        >
            Moviendo reserva…
        </div>

        @foreach ($estados as $estado)
            @php
                $items = $reservasPorEstado->get($estado->clave, collect());
            @endphp
            <section
                wire:key="col-{{ $estado->clave }}"
                class="flex w-80 shrink-0 flex-col rounded-xl bg-gray-50 ring-1 ring-gray-950/5 transition dark:bg-gray-900/40 dark:ring-white/10"
                x-bind:class="over === @js($estado->clave) && dragging
                    ? 'ring-2 ring-primary-500 bg-primary-50 dark:bg-primary-500/10 dark:ring-primary-400'
                    : ''"
                @dragover.prevent="enter(@js($estado->clave))"
                @dragenter.prevent="enter(@js($estado->clave))"
                @dragleave="leave($event, @js($estado->clave))"
                @drop.prevent="drop($event, @js($estado->clave))"
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

                <div class="flex flex-1 flex-col gap-2 px-2 pb-3 min-h-[14rem]">
                    <div
                        x-show="dragging && over === @js($estado->clave)"
                        x-cloak
                        class="rounded-lg border-2 border-dashed border-primary-400 bg-primary-100/70 px-3 py-6 text-center text-xs font-medium text-primary-700 dark:border-primary-400 dark:bg-primary-500/10 dark:text-primary-200"
                    >
                        Soltar aquí
                    </div>

                    @forelse ($items as $reserva)
                        <article
                            wire:key="card-{{ $reserva->id }}"
                            draggable="true"
                            @dragstart="start($event, {{ $reserva->id }})"
                            class="group cursor-grab rounded-lg bg-white p-3 shadow-sm ring-1 ring-gray-950/5 transition hover:-translate-y-0.5 hover:shadow-md hover:ring-primary-400 active:cursor-grabbing dark:bg-gray-800 dark:ring-white/10"
                            x-bind:class="dragging === @js((string) $reserva->id)
                                ? 'opacity-40 scale-[0.97] ring-2 ring-primary-400'
                                : ''"
                        >
                            <div class="mb-2 flex items-center justify-between text-[11px] text-gray-400">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M7 4h2v2H7V4zm4 0h2v2h-2V4zM7 9h2v2H7V9zm4 0h2v2h-2V9zM7 14h2v2H7v-2zm4 0h2v2h-2v-2z"/>
                                    </svg>
                                    Arrastrar
                                </span>
                                <a
                                    href="{{ \App\Filament\Resources\ReservasResource::getUrl('edit', ['record' => $reserva]) }}"
                                    class="font-medium text-primary-600 hover:underline dark:text-primary-300"
                                    draggable="false"
                                >
                                    Abrir
                                </a>
                            </div>
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
                        </article>
                    @empty
                        <p class="px-2 py-6 text-center text-xs text-gray-400" x-show="! (dragging && over === @js($estado->clave))">
                            Suelta aquí una reserva
                        </p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-filament-panels::page>
