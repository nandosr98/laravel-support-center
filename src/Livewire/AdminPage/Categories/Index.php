<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = [
        'category-created' => '$refresh',
    ];

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
