<div class="py-8">
    <div class="w-full mx-auto px-6">
        <div class="bg-white shadow rounded-xl border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-[420px_1fr] min-h-[calc(100vh-8rem)]">

                {{-- COLUMNA DE TICKETS --}}
                <section class="border-r border-gray-200 bg-white flex flex-col min-h-0">

                    {{-- Header --}}
                    <div class="h-16 px-5 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center">
                                <x-mary-icon name="o-inbox" class="w-5 h-5 text-gray-700" />
                            </div>

                            <div>
                                <h1 class="text-base font-semibold text-gray-900">
                                    Tickets de soporte
                                </h1>
                                <p class="text-xs text-gray-500">
                                    Solicitudes registradas
                                </p>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-gray-50"
                        >
                            <x-mary-icon name="o-adjustments-horizontal" class="w-5 h-5 text-gray-500" />
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="px-4 py-4 border-b border-gray-100">
                        <div class="relative">
                            <x-mary-icon
                                name="o-magnifying-glass"
                                class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                            />

                            <input
                                type="text"
                                placeholder="Buscar ticket..."
                                class="w-full h-10 pl-9 pr-3 rounded-xl border border-gray-200 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                            />
                        </div>
                    </div>

                    {{-- Tickets list --}}
                    <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            @php
                                $userName = $ticket->user ? $ticket->user->name : $ticket->email;

                                $priorityClasses = match($ticket->priority) {
                                    'urgent' => 'text-red-600 bg-red-50 border-red-100',
                                    'high' => 'text-orange-600 bg-orange-50 border-orange-100',
                                    'medium' => 'text-yellow-700 bg-yellow-50 border-yellow-100',
                                    'low' => 'text-green-700 bg-green-50 border-green-100',
                                    default => 'text-gray-600 bg-gray-50 border-gray-100',
                                };

                                $priorityBars = match($ticket->priority) {
                                    'urgent' => 'bg-red-500',
                                    'high' => 'bg-orange-500',
                                    'medium' => 'bg-yellow-400',
                                    'low' => 'bg-green-500',
                                    default => 'bg-gray-300',
                                };

                                $statusClasses = match($ticket->status) {
                                    'open' => 'text-blue-700',
                                    'pending' => 'text-yellow-700',
                                    'closed' => 'text-gray-500',
                                    'resolved' => 'text-green-700',
                                    default => 'text-gray-500',
                                };
                            @endphp

                            <button
                                type="button"
                                wire:click="viewTicket({{ $ticket->id }})"
                                class="w-full text-left px-4 py-4 hover:bg-gray-50 transition group"
                            >
                                <div class="flex gap-3">

                                    {{-- Avatar --}}
                                    <div class="shrink-0">
                                        <div class="w-9 h-9 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center text-sm font-semibold text-gray-700">
                                            {{ str($userName)->substr(0, 1)->upper() }}
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">

                                        {{-- Top line --}}
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $userName }}
                                                </p>
                                            </div>

                                            <span class="shrink-0 text-xs text-gray-400">
                                                {{ $ticket->updated_at?->isToday() ? $ticket->updated_at->format('H:i') : $ticket->updated_at?->format('d M') }}
                                            </span>
                                        </div>

                                        {{-- Subject + status --}}
                                        <div class="mt-1 flex items-center justify-between gap-3">
                                            <div class="min-w-0 flex items-center gap-2">
                                                <div class="flex items-end gap-[2px] shrink-0">
                                                    <span class="w-1 h-2 rounded-full {{ $priorityBars }}"></span>
                                                    <span class="w-1 h-3 rounded-full {{ $priorityBars }}"></span>
                                                    <span class="w-1 h-4 rounded-full {{ $priorityBars }}"></span>
                                                </div>

                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $ticket->subject }}
                                                </p>
                                            </div>

                                            <span class="shrink-0 text-xs font-medium {{ $statusClasses }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </div>


                                        <p class="mt-1 text-sm text-gray-500 truncate">
                                            Categoría:
                                            <span class="text-gray-700">
                                                {{ $ticket->category?->name ?? 'Sin categoría' }}
                                            </span>
                                        </p>


                                        <div class="mt-3 flex items-center justify-between gap-3">
                                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                                <x-mary-icon name="o-paper-clip" class="w-4 h-4" />
                                                <span>
                                                    {{ $ticket->attachments_count ?? 0 }} adjuntos
                                                </span>
                                            </div>

                                            <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-medium {{ $priorityClasses }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <div class="mx-auto w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                    <x-mary-icon name="o-inbox" class="w-6 h-6 text-gray-400" />
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-gray-900">
                                    No hay tickets
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Cuando se registre una solicitud aparecerá aquí.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="px-4 py-3 border-t border-gray-200 bg-white">
                        {{ $tickets->links() }}
                    </div>
                </section>


                <section class="bg-gray-50 flex flex-col min-h-0">

                    @if(!$selectedTicket)
                        {{-- Empty state --}}
                        <div class="flex-1 flex items-center justify-center">
                            <div class="text-center px-6">
                                <div class="mx-auto w-14 h-14 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                    <x-mary-icon name="o-chat-bubble-left-right" class="w-7 h-7 text-gray-400" />
                                </div>

                                <h2 class="mt-4 text-base font-semibold text-gray-900">
                                    Selecciona un ticket
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    El detalle de la conversación aparecerá en esta zona.
                                </p>
                            </div>
                        </div>
                    @else
                        @php
                            $userName = $selectedTicket->user
                                ? $selectedTicket->user->name
                                : $selectedTicket->email;

                            $userEmail = $selectedTicket->user?->email ?? $selectedTicket->email;

                            $statusClasses = match($selectedTicket->status) {
                                'open' => 'bg-blue-50 text-blue-700 border-blue-100',
                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                'resolved' => 'bg-green-50 text-green-700 border-green-100',
                                'closed' => 'bg-gray-100 text-gray-600 border-gray-200',
                                default => 'bg-gray-100 text-gray-600 border-gray-200',
                            };

                            $priorityClasses = match($selectedTicket->priority) {
                                'urgent' => 'bg-red-50 text-red-700 border-red-100',
                                'high' => 'bg-orange-50 text-orange-700 border-orange-100',
                                'medium' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                'low' => 'bg-green-50 text-green-700 border-green-100',
                                default => 'bg-gray-100 text-gray-600 border-gray-200',
                            };
                        @endphp

                        {{-- Header --}}
                        <div class="h-16 px-5 bg-white border-b border-gray-200 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-700 shrink-0">
                                    {{ str($userName)->substr(0, 1)->upper() }}
                                </div>

                                <div class="min-w-0">
                                    <h2 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $userName }}
                                    </h2>

                                    <p class="text-xs text-gray-500 truncate">
                                        {{ $userEmail }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                    {{ ucfirst($selectedTicket->status) }}
                </span>

                                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium {{ $priorityClasses }}">
                    {{ ucfirst($selectedTicket->priority) }}
                </span>

                                <button
                                    type="button"
                                    class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center hover:bg-gray-50"
                                >
                                    <x-mary-icon name="o-ellipsis-vertical" class="w-5 h-5 text-gray-500" />
                                </button>
                            </div>
                        </div>

                        {{-- Ticket summary --}}
                        <div class="px-5 py-4 bg-white border-b border-gray-200 shrink-0">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">
                                        Ticket #{{ $selectedTicket->uuid ?? $selectedTicket->id }}
                                    </p>

                                    <h1 class="mt-1 text-lg font-semibold text-gray-900 truncate">
                                        {{ $selectedTicket->subject }}
                                    </h1>

                                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                        <span>
                            Categoría:
                            <span class="font-medium text-gray-700">
                                {{ $selectedTicket->category?->name ?? 'Sin categoría' }}
                            </span>
                        </span>

                                        <span class="text-gray-300">•</span>

                                        <span>
                            Creado:
                            <span class="font-medium text-gray-700">
                                {{ $selectedTicket->created_at?->format('d/m/Y H:i') }}
                            </span>
                        </span>

                                        <span class="text-gray-300">•</span>

                                        <span>
                            Actualizado:
                            <span class="font-medium text-gray-700">
                                {{ $selectedTicket->updated_at?->format('d/m/Y H:i') }}
                            </span>
                        </span>
                                    </div>
                                </div>

                                <x-mary-button
                                    icon="o-arrow-top-right-on-square"
                                    label="Abrir"
                                    class="btn-sm btn-soft"
                                    wire:click="viewTicket({{ $selectedTicket->id }})"
                                />
                            </div>
                        </div>

                        {{-- Conversation --}}
                        <div class="flex-1 overflow-y-auto px-5 py-6 space-y-5">

                            {{-- Mensaje inicial del ticket --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-700 shrink-0">
                                    {{ str($userName)->substr(0, 1)->upper() }}
                                </div>

                                <div class="max-w-[75%]">
                                    <div class="rounded-2xl rounded-tl-md bg-white border border-gray-200 px-4 py-3 shadow-sm">
                                        <p class="text-sm text-gray-800 leading-relaxed">
                                            {{ $selectedTicket->description ?? 'Sin descripción inicial.' }}
                                        </p>
                                    </div>

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $selectedTicket->created_at?->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Mensajes/respuestas --}}
                            @forelse($selectedTicket->messages ?? [] as $message)
                                @php
                                    /*
                                        Ajusta esta condición según tu modelo:
                                        - $message->user_id === auth()->id()
                                        - $message->is_admin
                                        - $message->sender_type === 'admin'
                                    */
                                    $isAdminMessage = $message->is_admin ?? false;

                                    $messageUserName = $message->user?->name
                                        ?? ($isAdminMessage ? 'Soporte' : $userName);
                                @endphp

                                <div class="flex items-start gap-3 {{ $isAdminMessage ? 'justify-end' : '' }}">
                                    @unless($isAdminMessage)
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-700 shrink-0">
                                            {{ str($messageUserName)->substr(0, 1)->upper() }}
                                        </div>
                                    @endunless

                                    <div class="max-w-[75%] {{ $isAdminMessage ? 'items-end' : '' }}">
                                        <div @class([
                            'rounded-2xl px-4 py-3 shadow-sm',
                            'rounded-tr-md bg-blue-600 text-white' => $isAdminMessage,
                            'rounded-tl-md bg-white border border-gray-200 text-gray-800' => !$isAdminMessage,
                        ])>
                                            <p class="text-sm leading-relaxed">
                                                {{ $message->message ?? $message->body ?? '' }}
                                            </p>
                                        </div>

                                        <p class="mt-1 text-xs text-gray-400 {{ $isAdminMessage ? 'text-right' : '' }}">
                                            {{ $message->created_at?->format('H:i') }}
                                        </p>
                                    </div>

                                    @if($isAdminMessage)
                                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-semibold text-white shrink-0">
                                            S
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-sm text-gray-500">
                                        Todavía no hay respuestas en este ticket.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Reply box --}}
                        <div class="px-5 py-4 bg-white border-t border-gray-200 shrink-0">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3">
                <textarea
                    wire:model.defer="replyMessage"
                    rows="3"
                    placeholder="Escribe una respuesta..."
                    class="w-full resize-none border-0 bg-transparent text-sm text-gray-700 placeholder:text-gray-400 focus:ring-0 focus:outline-none"
                ></textarea>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            class="w-9 h-9 rounded-lg flex items-center justify-center hover:bg-white"
                                        >
                                            <x-mary-icon name="o-paper-clip" class="w-5 h-5 text-gray-500" />
                                        </button>
                                    </div>

                                    <x-mary-button
                                        label="Enviar respuesta"
                                        icon="o-paper-airplane"
                                        class="btn-primary btn-sm"
                                        wire:click="sendReply"
                                    />
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

            </div>
        </div>
    </div>
</div>
