<div class="min-h-screen bg-gray-100 py-6">
    <div class="w-full mx-auto px-6">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Tickets</span>
                    <span>/</span>
                    <span class="text-gray-800">Detalle del ticket</span>
                </div>

                <h1 class="mt-3 text-2xl font-semibold text-gray-950">
                    {{ $ticket->subject ?? 'Ticket sin asunto' }}
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Ticket #{{ $ticket->uuid ?? '—' }}
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <x-mary-button
                    tag="a"
                    href="{{ route('support.admin-page.tickets') }}"
                    icon="o-arrow-left"
                    class="btn-soft btn-sm w-full sm:w-auto"
                >
                    Volver
                </x-mary-button>


                <x-mary-button
                    icon="o-check-circle"
                    class="btn-primary btn-sm w-full sm:w-auto"
                    wire:click="markAsResolved"
                >
                    Resolver
                </x-mary-button>
            </div>
        </div>

        {{-- Main Layout --}}
        <div class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">

            {{-- Left Panel --}}
            <div class="space-y-6">

                {{-- Ticket Details --}}
                <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-semibold text-gray-950">
                                    Detalles del ticket
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Información principal de la solicitud.
                                </p>
                            </div>

                            <div class="shrink-0">
                                @php
                                    $statusClasses = match ($ticket->status ?? null) {
                                        'open' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                        'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                        'resolved' => 'bg-green-50 text-green-700 ring-green-600/20',
                                        'closed' => 'bg-gray-100 text-gray-700 ring-gray-600/20',
                                        default => 'bg-gray-100 text-gray-700 ring-gray-600/20',
                                    };
                                @endphp

                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses }}">
                                    {{ $ticket->status ? Str::headline($ticket->status) : 'Sin estado' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-5">
                        <dl class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Estado
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $ticket->status ? Str::headline($ticket->status) : 'Sin estado' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Prioridad
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $ticket->priority ? Str::headline($ticket->priority) : 'Sin definir' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Categoría
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $ticket->category ?? 'Sin categoría' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Asignado a
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $ticket->assigned_to ? '#'.$ticket->assigned_to : 'Sin asignar' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </section>

                {{-- Requester Details --}}
                <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-5">
                        <h2 class="text-base font-semibold text-gray-950">
                            Datos del solicitante
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Información de contacto asociada al ticket.
                        </p>
                    </div>

                    <div class="px-6 py-5">
                        <dl class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Nombre
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ optional($ticket->user)->name ?? 'Sin usuario asignado' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Correo electrónico
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $ticket->email ?? optional($ticket->user)->email ?? 'No registrado' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </section>

                {{-- Tracking --}}
                <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-5">
                        <h2 class="text-base font-semibold text-gray-950">
                            Seguimiento
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Fechas relevantes del ciclo de vida del ticket.
                        </p>
                    </div>

                    <div class="px-6 py-5">
                        <dl class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Creado
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? 'Sin fecha' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Última actualización
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ optional($ticket->updated_at)->format('d/m/Y H:i') ?? 'Sin actualización' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Resuelto
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ optional($ticket->resolved_at)->format('d/m/Y H:i') ?? 'Sin resolver' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Cierre
                                </dt>
                                <dd class="mt-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ optional($ticket->closed_at)->format('d/m/Y H:i') ?? 'Sin cerrar' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </section>
            </div>

            {{-- Right Preview Panel --}}
            <aside class="xl:sticky xl:top-6 xl:self-start">
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">
                        <div>
                            <h2 class="text-base font-semibold text-gray-950">
                                Vista del ticket
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Resumen visual de la solicitud.
                            </p>
                        </div>

                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-950 text-white">
                            <x-mary-icon name="o-ticket" class="h-5 w-5" />
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                            {{-- Preview Header --}}
                            <div class="mb-6 flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        Ticket
                                    </p>
                                    <h3 class="mt-1 text-2xl font-semibold text-gray-950">
                                        #{{ $ticket->uuid ?? '—' }}
                                    </h3>
                                </div>

                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses }}">
                                    {{ $ticket->status ? Str::headline($ticket->status) : 'Sin estado' }}
                                </span>
                            </div>

                            {{-- Preview Meta --}}
                            <div class="grid gap-5 border-b border-gray-100 pb-6 sm:grid-cols-2">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Solicitante
                                    </p>
                                    <p class="mt-2 text-sm font-semibold text-gray-950">
                                        {{ optional($ticket->user)->name ?? 'Sin usuario asignado' }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $ticket->email ?? optional($ticket->user)->email ?? 'No registrado' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Categoría
                                    </p>
                                    <p class="mt-2 text-sm font-semibold text-gray-950">
                                        {{ $ticket->category ?? 'Sin categoría' }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Prioridad: {{ $ticket->priority ? Str::headline($ticket->priority) : 'Sin definir' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Preview Subject --}}
                            <div class="border-b border-gray-100 py-6">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Asunto
                                </p>
                                <p class="mt-2 text-base font-semibold text-gray-950">
                                    {{ $ticket->subject ?? 'Ticket sin asunto' }}
                                </p>
                            </div>

                            {{-- Preview Description --}}
                            <div class="border-b border-gray-100 py-6">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Descripción
                                </p>

                                @if ($ticket->description)
                                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">
                                        {{ $ticket->description }}
                                    </p>
                                @else
                                    <p class="mt-3 text-sm text-gray-500">
                                        Este ticket no tiene una descripción registrada.
                                    </p>
                                @endif
                            </div>

                            {{-- Preview Dates --}}
                            <div class="space-y-3 py-6">
                                <div class="flex items-center justify-between gap-4 text-sm">
                                    <span class="text-gray-500">Creado</span>
                                    <span class="font-medium text-gray-950">
                                        {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? 'Sin fecha' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4 text-sm">
                                    <span class="text-gray-500">Última actualización</span>
                                    <span class="font-medium text-gray-950">
                                        {{ optional($ticket->updated_at)->format('d/m/Y H:i') ?? 'Sin actualización' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4 text-sm">
                                    <span class="text-gray-500">Asignado a</span>
                                    <span class="font-medium text-gray-950">
                                        {{ $ticket->assigned_to ? '#'.$ticket->assigned_to : 'Sin asignar' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Preview Footer --}}
                            <div class="rounded-xl bg-gray-50 px-4 py-4">
                                <p class="text-sm leading-6 text-gray-600">
                                    Este panel muestra una vista resumida del ticket para facilitar su revisión rápida por parte del equipo de soporte.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>
