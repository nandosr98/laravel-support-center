<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto space-y-6">


        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Ticket #{{ $ticket->uuid }}
                    </p>

                    <h1 class="mt-1 text-2xl font-semibold text-gray-900">
                        {{ $ticket->subject }}
                    </h1>

                    <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 font-medium text-blue-700">
                            {{ $ticket->category?->name ?? 'Sin categoría' }}
                        </span>

                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 font-medium text-gray-700">
                            Estado: {{ ucfirst($ticket->status) }}
                        </span>

                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 font-medium text-gray-700">
                            Prioridad: {{ ucfirst($ticket->priority) }}
                        </span>
                    </div>
                </div>

                <div class="text-sm text-gray-500 sm:text-right">
                    <p>Creado el</p>
                    <p class="font-medium text-gray-900">
                        {{ $ticket->created_at?->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Conversación --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">
                    Conversación
                </h2>
                <p class="text-sm text-gray-500">
                    Aquí puedes ver todos los mensajes relacionados con esta solicitud.
                </p>
            </div>

            <div class="p-6 space-y-6">

                @forelse($ticket->messages as $message)

                    @php
                        $isAdmin = $message->sender_type === 'admin';
                    @endphp

                    <div class="flex {{ $isAdmin ? 'justify-start' : 'justify-end' }}">
                        <div class="max-w-[85%] sm:max-w-[70%]">

                            {{-- Autor --}}
                            <div class="mb-1 flex items-center gap-2 {{ $isAdmin ? 'justify-start' : 'justify-end' }}">
                                <span class="text-xs font-medium text-gray-500">
                                    {{ $isAdmin ? 'Soporte' : 'Tú' }}
                                </span>

                                <span class="text-xs text-gray-400">
                                    {{ $message->created_at?->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            {{-- Burbuja --}}
                            <div
                                class="rounded-2xl px-4 py-3 text-sm leading-6 shadow-sm
                                {{ $isAdmin
                                    ? 'bg-gray-100 text-gray-800 rounded-tl-sm'
                                    : 'bg-blue-600 text-white rounded-tr-sm'
                                }}"
                            >
                                {!! nl2br(e($message->message)) !!}
                            </div>

                            {{-- Adjuntos del mensaje --}}
                            @if($message->attachments && $message->attachments->count())
                                <div class="mt-2 space-y-2">
                                    @foreach($message->attachments as $attachment)
                                        <a
                                            href="{{ Storage::url($attachment->path) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                                        >
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94a3 3 0 114.243 4.243L8.552 18.32a1.5 1.5 0 11-2.121-2.121l9.9-9.9" />
                                            </svg>

                                            {{ $attachment->name ?? 'Archivo adjunto' }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>

                @empty

                    <div class="text-center py-12">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                            <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-gray-900">
                            Todavía no hay mensajes
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Cuando soporte responda, los mensajes aparecerán aquí.
                        </p>
                    </div>

                @endforelse

            </div>
        </div>

        {{-- Formulario para responder --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900">
                Enviar nuevo mensaje
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Puedes añadir información adicional o responder al equipo de soporte.
            </p>

            <form wire:submit.prevent="sendMessage" enctype="multipart/form-data" class="mt-5 space-y-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Mensaje
                    </label>

                    <textarea
                        wire:model.defer="message"
                        rows="5"
                        placeholder="Escribe tu respuesta..."
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    ></textarea>

                    @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Archivos adjuntos
                    </label>

                    <input
                        type="file"
                        wire:model="attachments"
                        multiple
                        class="mt-1 block w-full text-sm text-gray-500
                               file:mr-4 file:rounded-lg file:border-0
                               file:bg-gray-100 file:px-4 file:py-2
                               file:text-sm file:font-medium file:text-gray-700
                               hover:file:bg-gray-200"
                    >

                    @error('attachments.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="attachments" class="mt-1 text-sm text-blue-600">
                        Subiendo archivos...
                    </div>
                </div>

                {{-- Preview simple de archivos seleccionados --}}
                @if(!empty($attachments))
                    <div class="rounded-xl bg-gray-50 border border-gray-200 p-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">
                            Archivos seleccionados:
                        </p>

                        <ul class="space-y-1 text-sm text-gray-600">
                            @foreach($attachments as $attachment)
                                <li class="flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                    {{ $attachment->getClientOriginalName() }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-end">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="sendMessage">
                            Enviar mensaje
                        </span>

                        <span wire:loading wire:target="sendMessage">
                            Enviando...
                        </span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
