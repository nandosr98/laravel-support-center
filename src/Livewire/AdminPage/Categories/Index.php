<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $showCreateModal = false;

    public ?string $flashMessage = null;

    protected $listeners = [
        'category-created' => 'handleCategoryCreated',
    ];

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
    }

    public function handleCategoryCreated(?string $message = null): void
    {
        $this->flashMessage = $message ?? 'Categoría creada correctamente.';
        $this->resetPage();
        $this->closeCreateModal();
    }

    public function dismissFlashMessage(): void
    {
        $this->flashMessage = null;
    }

    public function render()
    {
        $perPage = config('support-center.admin-page-pagination', 15);

        $categories = BaseSupportCategory::query()
            ->withCount('tickets')
            ->latest('created_at')
            ->paginate($perPage);

        return view('laravel-support-center::livewire.categories.index', [
            'categories' => $categories,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
