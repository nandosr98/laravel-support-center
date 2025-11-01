<x-mary-menu-sub title="Soporte">
    <x-mary-menu-item title="Tickets" link="{{ route('support.admin-page', ['section' => 'tickets']) }}" no-wire-navigate/>
    <x-mary-menu-item title="Categorías" link="{{ route('support.admin-page', ['section' => 'categorias']) }}" no-wire-navigate/>
    <x-mary-menu-item title="Etiquetas" link="{{ route('support.admin-page', ['section' => 'etiquetas']) }}" no-wire-navigate/>
    <x-mary-menu-item title="Agentes" link="{{ route('support.admin-page', ['section' => 'agentes']) }}" no-wire-navigate/>
</x-mary-menu-sub>
