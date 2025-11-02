@php use Illuminate\Support\Str; @endphp
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
                @php
                    $headersInfo = [
                       ['key' => 'name', 'label' => 'Categoría', 'class' => 'w-1'],
                       ['key' => 'description', 'label' => 'Description'],
                       ['key' => 'priority', 'label' => 'Prioridad'],
                       ['key' => 'tickets_count', 'label' => 'Tickets Asociados'],
                       ['key' => 'created_at', 'label' => 'Creado'],
                       ['key' => 'updated_at', 'label' => 'Ultima actualización'],
                       ['key' => 'actions', 'label' => ''],
                   ];
                @endphp
                <x-mary-table
                    :headers="$headersInfo"
                    :rows="$categories"
                    show-empty-text
                    empty-text="No hay categorías creadas."
                    with-pagination
                    per-page="5"
                    :per-page-values="[3, 5, 10]">
                    @scope('name', $row)
                    <div class="font-semibold text-gray-900">
                        {{ $row->name ?? 'Sin nombre' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        #{{ $row->id }}
                    </div>
                    @endscope

                    @scope('description', $row)
                    {{ $row->description
                        ? Str::limit($row->description, 90)
                        : 'Sin descripción' }}
                    @endscope

                    @scope('tickets_count', $row)
                        {{$row->tickets_count ?? ($row->relationLoaded('tickets') ? $row->tickets->count() : null) }}
                    @endscope

                    @scope('actions', $row)
                        <div class="flex justify-end gap-2">
                            <x-mary-button icon="o-pencil" wire:click="showEditCategory({{ $row->id }})" class="btn-sm" />
                            <x-mary-button icon="o-trash" wire:click="deleteCategory({{ $row->id }})" class="btn-sm" />
                        </div>
                    @endscope
                </x-mary-table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <x-mary-modal wire:model="categoryModal" title="Añadir nueva categoría">
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
            <x-mary-button label="Crear Categoría" class="btn-primary" wire:click="createCategory"/>
            <x-mary-button label="Cancelar" class="btn-success" wire:click="$wire.categoryModal = false"/>
        </x-slot:actions>
    </x-mary-modal>

    <x-mary-modal wire:model="editCategoryModal" title="Editar categoría">
        <x-slot name="title">Editar Categoría</x-slot>
        <x-mary-input
            label="Nombre"
            wire:model="editCategoryForm.name"
            placeholder="Nombre de la categoría"
            required
        />

        <x-mary-textarea
            label="Descripción"
            rows="6"
            wire:model="editCategoryForm.description"
            placeholder="Descripción de la categoría"
        />

        <x-mary-select
            label="Prioridad"
            wire:model="editCategoryForm.priority"
            :options="$categoryPriorities"
            option-label="label"
            option-value="key"
            selected="{{ $editCategoryForm['priority'] }}"
            placeholder="Selecciona una prioridad"
        />

        <x-slot:actions>
            <x-mary-button label="Editar Categoría" class="btn-primary" wire:click="editCategory({{$editCategoryForm['id']}})"/>
            <x-mary-button label="Cancelar" class="btn-success" wire:click="$wire.editCategoryModal = false"/>
        </x-slot:actions>
    </x-mary-modal>

    <x-mary-modal wire:model="confirmDeleteModal" title="¿Estas seguro de eliminar esta categoría?">
        <x-slot name="title">¿Estas seguro de eliminar esta categoría?</x-slot>
        <x-slot:actions>
            <x-mary-button label="Eliminar Categoría" class="btn-danger" wire:click="confirmDeleteCategory({{$categoryToDelete}})"/>
            <x-mary-button label="Cancelar" class="btn-success" wire:click="$set('confirmDeleteModal',false)"/>
        </x-slot:actions>
    </x-mary-modal>
</div>
