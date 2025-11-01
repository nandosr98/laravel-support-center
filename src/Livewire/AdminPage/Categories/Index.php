<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $categoryModal = false;

    public ?string $flashMessage = null;

    protected $listeners = [
        'category-created' => 'handleCategoryCreated',
    ];

    public function handleCategoryCreated(?string $message = null): void
    {
        $this->flashMessage = $message ?? 'Categoría creada correctamente.';
        $this->resetPage();
    }

    public function render()
    {
        $perPage = 15;

        $categories = BaseSupportCategory::query()
            ->withCount('tickets')
            ->latest('created_at')
            ->paginate($perPage);

        return view('laravel-support-center::livewire.categories.index', [
            'categories' => $categories,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
