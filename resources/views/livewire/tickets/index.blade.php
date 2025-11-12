<div class="py-8">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Tickets de soporte</h1>
                <p class="mt-1 text-sm text-gray-500">Gestiona las solicitudes registradas por los usuarios</p>
            </div>

            <div class="overflow-x-auto">
                @php
                    $headers = [
                        ['key' => 'user', 'label' => 'Usuario'],
                        ['key' => 'subject', 'label' => 'Asunto'],
                        ['key' => 'category', 'label' => 'Categoría'],
                        ['key' => 'status', 'label' => 'Estado'],
                        ['key' => 'priority', 'label' => 'Prioridad'],
                        ['key' => 'updated_at', 'label' => 'Actualizado'],
                        ['key' => 'actions', 'label' => ''],
                    ];
                @endphp

                <x-mary-table
                    :headers="$headers"
                    :rows="$tickets"
                    show-empty-text
                    empty-text="No hay tickets!"
                    with-pagination
                    per-page="ticketsLimit"
                    :per-page-values="[3, 5, 10]">

                    @scope('user', $row)
                        {{ $row->user->name ?? $row->email }}
                    @endscope
                    @scope('actions', $row)
                        <div class="flex justify-end gap-2">
                            <x-mary-button icon="o-eye" wire:click="viewTicket({{ $row->id }})" class="btn-sm" />
                        </div>
                    @endscope
                </x-mary-table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
