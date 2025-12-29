<div class="py-8">
    <div class="max-w-5xl mx-auto px-6 space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500">Ticket #{{ $ticket->id ?? '—' }}</p>
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ $ticket->subject ?? 'Ticket sin asunto' }}
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $ticket->uuid ?? 'Sin UUID asociado' }}
                </p>
            </div>
            <x-mary-button tag="a" href="{{ route('support.admin-page.tickets') }}" icon="o-arrow-left"
                           class="btn-soft btn-sm w-full sm:w-auto">
                Volver
            </x-mary-button>
        </div>

        <div class="divide-y divide-gray-200 rounded-lg bg-white shadow">
            <div class="px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-900">Resumen del ticket</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="text-base text-gray-900">
                            {{ $ticket->status ? Str::headline($ticket->status) : 'Sin estado' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Prioridad</dt>
                        <dd class="text-base text-gray-900">
                            {{ $ticket->priority ? Str::headline($ticket->priority) : 'Sin definir' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Categoría</dt>
                        <dd class="text-base text-gray-900">
                            {{ $ticket->category ?? 'Sin categoría' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="px-6 py-5 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Descripción</h2>
                @if ($ticket->description)
                    <p class="mt-3 whitespace-pre-line text-gray-700">{{ $ticket->description }}</p>
                @else
                    <p class="mt-3 text-sm text-gray-500">Este ticket no tiene una descripción registrada.</p>
                @endif
            </div>

            <div class="grid gap-6 px-6 py-5 md:grid-cols-2">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Datos del solicitante</h3>
                    <dl class="mt-3 space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                            <dd class="text-base text-gray-900">
                                {{ optional($ticket->user)->name ?? 'Sin usuario asignado' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Correo electrónico</dt>
                            <dd class="text-base text-gray-900">
                                {{ $ticket->email ?? optional($ticket->user)->email ?? 'No registrado' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Asignado a</dt>
                            <dd class="text-base text-gray-900">
                                {{ $ticket->assigned_to ? '#'.$ticket->assigned_to : 'Sin asignar' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900">Seguimiento</h3>
                    <dl class="mt-3 space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Creado</dt>
                            <dd class="text-base text-gray-900">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                            <dd class="text-base text-gray-900">
                                {{ optional($ticket->updated_at)->format('d/m/Y H:i') ?? 'Sin actualización' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Resuelto</dt>
                            <dd class="text-base text-gray-900">
                                {{ optional($ticket->resolved_at)->format('d/m/Y H:i') ?? 'Sin resolver' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cierre</dt>
                            <dd class="text-base text-gray-900">
                                {{ optional($ticket->closed_at)->format('d/m/Y H:i') ?? 'Sin cerrar' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
