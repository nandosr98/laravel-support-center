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
                <x-mary-button icon="o-plus" class="btn-soft btn-sm" @click="$wire.categoryModal = true"/>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
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

    <x-mary-modal  wire:model="categoryModal" title="Añadir nueva categoría">
        <x-slot name="title">Nueva Categoría</x-slot>
        <x-mary-input
            label="Nombre"
            wire:model="categoryForm.name"
            placeholder="Nombre de la categoría"
            required
        />

        <x-mary-textarea
            label="Descripción"
            rows="6"
            wire:model="categoryForm.description"
            placeholder="Descripción de la categoría"
        />

        <x-mary-select
            label="Prioridad"
            wire:model="categoryForm.priority"
            :options="$categoryPriorities"
            option-label="label"
            option-value="key"
            placeholder="Selecciona una prioridad"
        />

        <x-slot:actions>
            <x-mary-button label="Crear Categoría" class="btn-primary" wire:click="createCategory" />
            <x-mary-button label="Cancelar" class="btn-success" wire:click="$wire.categoryModal = false" />
        </x-slot:actions>
    </x-mary-modal>
</div>
