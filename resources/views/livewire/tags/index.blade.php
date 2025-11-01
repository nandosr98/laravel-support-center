<div class="py-8">
    <div class="max-w-6xl mx-auto px-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Etiquetas de soporte</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Administra las etiquetas disponibles para clasificar los tickets.
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span class="font-medium text-gray-900">{{ $tags->total() }}</span>
                <span>etiqueta{{ $tags->total() === 1 ? '' : 's' }} cread{{ $tags->total() === 1 ? 'a' : 'as' }}</span>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Mostrando del {{ $tags->firstItem() ?? 0 }} al {{ $tags->lastItem() ?? 0 }}.
                    </p>
                </div>
                <div wire:loading class="flex items-center gap-2 text-sm text-blue-600">
                    <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span>Cargando...</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Etiqueta
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Color
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tickets asociados
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creado
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actualizado
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tags as $tag)
                        @php
                            $ticketsCount = $tag->tickets_count
                                ?? ($tag->relationLoaded('tickets') ? $tag->tickets->count() : null);
                            $colorValue = is_string($tag->color) ? trim($tag->color) : null;
                            $isValidHex = $colorValue && preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $colorValue);
                            $colorPreview = $isValidHex ? $colorValue : '#e5e7eb';
                        @endphp
                        <tr wire:key="tag-{{ $tag->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-semibold text-gray-900">
                                    {{ $tag->name ?? 'Sin nombre' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    #{{ $tag->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full border border-gray-300"
                                          style="background-color: {{ $colorPreview }};"></span>
                                    <span>{{ $colorValue ?? 'Sin color' }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $ticketsCount ?? 'N/D' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ optional($tag->created_at)->format('d/m/Y H:i') ?? 'N/D' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ optional($tag->updated_at)->diffForHumans() ?? 'Sin cambios' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                No hay etiquetas registradas por el momento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tags->links() }}
            </div>
        </div>
    </div>
</div>
