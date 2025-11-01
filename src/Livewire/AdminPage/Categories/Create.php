<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    public ?string $description = null;

    public string $priority = 'medium';

    public ?string $successMessage = null;

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
        $this->successMessage = 'Categoría creada correctamente.';

        $this->dispatch('category-created');
    }

    public function render()
    {
        return view('laravel-support-center::livewire.categories.create');
    }
}
