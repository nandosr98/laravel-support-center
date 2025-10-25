@php
    // Obtenemos el layout configurado o usamos uno por defecto
    $layout = config('support-center.layout', 'x-app-layout');
@endphp

{{-- Renderizamos dinámicamente el layout configurado --}}
<{{ $layout }}>
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Enviar solicitud de soporte</h1>

    {{-- Aquí va tu formulario completo --}}
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}" />
        {{-- ... resto del formulario ... --}}

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                Enviar solicitud
            </button>
        </div>
    </form>
</div>
</{{ $layout }}>

