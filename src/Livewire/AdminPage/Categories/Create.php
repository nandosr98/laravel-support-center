<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    public ?string $description = null;

    public string $priority = 'medium';

    protected array $rules = [
        'name' => ['required', 'string', 'max:190'],
        'description' => ['nullable', 'string'],
        'priority' => ['required', 'in:low,medium,high,urgent'],
    ];

    public function save(): void
    {
        $validated = $this->validate();

        BaseSupportCategory::create($validated);

        $this->resetValidation();
        $this->reset(['name', 'description', 'priority']);
        $this->priority = 'medium';

        $this->dispatch('category-created', message: 'Categoría creada correctamente.');
    }

    public function render()
    {
        return view('laravel-support-center::livewire.categories.create');
    }
}
