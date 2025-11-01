<div class="py-8" wire:keydown.escape.window="closeCreateModal">
    <div class="max-w-6xl mx-auto px-6 space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Categorías de soporte</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Organiza y consulta las categorías utilizadas para clasificar los tickets.
                </p>
            </div>
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:gap-4">
                <div class="flex items-center justify-between gap-2 text-sm text-gray-500 sm:justify-end">
                    <span class="font-medium text-gray-900">{{ $categories->total() }}</span>
                    <span>categoría{{ $categories->total() === 1 ? '' : 's' }} registrad{{ $categories->total() === 1 ? 'a' : 'as' }}</span>
                </div>
                <button
                    type="button"
                    wire:click="openCreateModal"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nueva categoría</span>
                </button>
            </div>
        </div>

        @if($flashMessage)
            <div class="flex items-start justify-between gap-3 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                <span>{{ $flashMessage }}</span>
                <button type="button" wire:click="dismissFlashMessage" class="text-green-700 hover:text-green-900">
                    <span class="sr-only">Cerrar mensaje</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Mostrando del {{ $categories->firstItem() ?? 0 }} al {{ $categories->lastItem() ?? 0 }}.
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
                            Categoría
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prioridad
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
                    @php
                        $priorityLabels = [
                            'low' => 'Baja',
                            'medium' => 'Media',
                            'high' => 'Alta',
                            'urgent' => 'Urgente',
                        ];
                        $priorityClasses = [
                            'low' => 'bg-green-100 text-green-800',
                            'medium' => 'bg-blue-100 text-blue-800',
                            'high' => 'bg-amber-100 text-amber-800',
                            'urgent' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    @forelse($categories as $category)
                        @php
                            $priorityKey = strtolower($category->priority ?? 'medium');
                            $priorityLabel = $priorityLabels[$priorityKey] ?? ucfirst($priorityKey);
                            $priorityClass = $priorityClasses[$priorityKey] ?? 'bg-gray-100 text-gray-700';
                            $ticketsCount = $category->tickets_count
                                ?? ($category->relationLoaded('tickets') ? $category->tickets->count() : null);
                        @endphp
                        <tr wire:key="category-{{ $category->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-semibold text-gray-900">
                                    {{ $category->name ?? 'Sin nombre' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    #{{ $category->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $category->description
                                    ? \Illuminate\Support\Str::limit($category->description, 90)
                                    : 'Sin descripción' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $priorityClass }}">
                                    {{ $priorityLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $ticketsCount ?? 'N/D' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ optional($category->created_at)->format('d/m/Y H:i') ?? 'N/D' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ optional($category->updated_at)->diffForHumans() ?? 'Sin cambios' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                No hay categorías registradas por el momento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    @if($showCreateModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/50" wire:click="closeCreateModal"></div>
            <div class="relative z-50 w-full max-w-lg overflow-hidden rounded-lg bg-white shadow-xl" wire:click.stop>
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Nueva categoría</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Crea una categoría para clasificar los tickets de soporte.
                        </p>
                    </div>
                    <button type="button" wire:click="closeCreateModal"
                            class="rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="sr-only">Cerrar modal</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-5">
                    <livewire:laravel-support-center.livewire.categories.create wire:key="create-category-modal"/>
                </div>
            </div>
        </div>
    @endif
</div>
