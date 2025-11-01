<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Nueva categoría</h2>
        <p class="mt-1 text-sm text-gray-500">
            Crea una categoría para clasificar los tickets de soporte.
        </p>
    </div>

    <div class="px-6 py-5 space-y-5">
        @if ($successMessage)
            <div class="p-3 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md">
                {{ $successMessage }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700" for="category-name">Nombre</label>
                <input
                    id="category-name"
                    type="text"
                    wire:model.defer="name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Ej. Incidencias generales"
                >
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="category-priority">Prioridad</label>
                <select
                    id="category-priority"
                    wire:model.defer="priority"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="low">Baja</option>
                    <option value="medium">Media</option>
                    <option value="high">Alta</option>
                    <option value="urgent">Urgente</option>
                </select>
                @error('priority')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="category-description">Descripción</label>
                <textarea
                    id="category-description"
                    rows="4"
                    wire:model.defer="description"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Describe cuándo debe utilizarse esta categoría."
                ></textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md"
                >
                    <svg
                        wire:loading
                        wire:target="save"
                        class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Crear categoría</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
