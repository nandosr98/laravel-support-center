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
            <x-mary-button icon="o-plus" class="btn-soft btn-sm" @click="$wire.tagModal = true"/>
        </div>

        <div class="bg-white shadow rounded-lg">

            <div class="overflow-x-auto">
                @php
                    $headersInfo = [
                       ['key' => 'name', 'label' => 'Etiqueta', 'class' => 'w-1'],
                       ['key' => 'color', 'label' => 'Color'],
                       ['key' => 'created_at', 'label' => 'Creado'],
                       ['key' => 'updated_at', 'label' => 'Ultima actualización'],
                       ['key' => 'actions', 'label' => ''],
                   ];
                @endphp
                <x-mary-table
                    :headers="$headersInfo"
                    :rows="$tags"
                    show-empty-text
                    empty-text="No hay etiquetas creadas."
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

                    @scope('color', $row)
                    {{ $row->color }}
                    @endscope

                    @scope('actions', $row)
                    <div class="flex justify-end gap-2">
                        <x-mary-button icon="o-pencil" wire:click="showEditTag({{ $row->id }})" class="btn-sm" />
                        <x-mary-button icon="o-trash" wire:click="deleteTag({{ $row->id }})" class="btn-sm" />
                    </div>
                    @endscope
                </x-mary-table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tags->links() }}
            </div>
        </div>
    </div>

    <x-mary-modal wire:model="tagModal" title="Añadir nueva etiqueta">
        <x-slot name="title">Nueva Etiqueta</x-slot>
        <x-mary-input
            label="Nombre"
            wire:model="tagForm.name"
            placeholder="Nombre de la etiqueta"
            required
        />

        <x-mary-colorpicker
            label="Color"
            wire:model="tagForm.color"
            required
        />

        <x-slot:actions>
            <x-mary-button label="Crear Etiqueta" class="btn-success" wire:click="createTag"/>
            <x-mary-button label="Cancelar" class="btn-danger" wire:click="$wire.tagModal = false"/>
        </x-slot:actions>
    </x-mary-modal>

    <x-mary-modal wire:model="editTagModal" title="Editar Etiqueta">
        <x-slot name="title">Editar Etiqueta</x-slot>
        <x-mary-input
            label="Nombre"
            wire:model="editTagForm.name"
            placeholder="Nombre de la etiqueta"
            required
        />

        <x-mary-colorpicker
            label="Color"
            wire:model="editTagForm.color"
            required
        />

        <x-slot:actions>
            <x-mary-button label="Editar Etiqueta" class="btn-success" wire:click="editTag({{$editTagForm['id']}})"/>
            <x-mary-button label="Cancelar" class="btn-danger" wire:click="$set('editTagModal',false)"/>
        </x-slot:actions>
    </x-mary-modal>

    <x-mary-modal wire:model="confirmDeleteModal" title="¿Estas seguro de eliminar esta etiqueta?">
        <x-slot name="title">¿Estas seguro de eliminar esta etiqueta?</x-slot>
        <x-slot:actions>
            <x-mary-button label="Eliminar Etiqueta" class="btn-danger" wire:click="confirmDeleteTag({{$tagToDelete}})"/>
            <x-mary-button label="Cancelar" class="btn-primary" wire:click="$set('confirmDeleteModal',false)"/>
        </x-slot:actions>
    </x-mary-modal>
</div>
