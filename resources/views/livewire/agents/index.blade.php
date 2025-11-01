<div class="py-8">
    <div class="max-w-6xl mx-auto px-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Agentes de soporte</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Supervisa a los agentes asignados al centro de soporte.
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span class="font-medium text-gray-900">{{ $agents->total() }}</span>
                <span>agente{{ $agents->total() === 1 ? '' : 's' }} en total</span>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Mostrando del {{ $agents->firstItem() ?? 0 }} al {{ $agents->lastItem() ?? 0 }}.
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
                            Agente
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actualizado
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($agents as $agent)
                        @php
                            $statusLabel = $agent->active ? 'Activo' : 'Inactivo';
                            $statusClass = $agent->active
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-700';
                        @endphp
                        <tr wire:key="agent-{{ $agent->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-semibold text-gray-900">
                                    Agente #{{ $agent->id }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Registrado {{ optional($agent->created_at)->format('d/m/Y H:i') ?? 'N/D' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($agent->relationLoaded('user') || $agent->user)
                                    <div class="font-medium text-gray-900">
                                        {{ optional($agent->user)->name ?? 'Usuario sin nombre' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ optional($agent->user)->email ?? 'Correo no disponible' }}
                                    </div>
                                @else
                                    <div class="font-medium text-gray-900">Sin usuario asociado</div>
                                    <div class="text-xs text-gray-500">N/D</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $agent->role ? ucfirst($agent->role) : 'Sin rol asignado' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ optional($agent->updated_at)->diffForHumans() ?? 'Sin cambios' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                No hay agentes registrados por el momento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $agents->links() }}
            </div>
        </div>
    </div>
</div>
