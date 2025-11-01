<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Categories;

use LaravelSupportCenter\Models\BaseSupportAgent;
use LaravelSupportCenter\Models\BaseSupportCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        $categories = BaseSupportCategory::query()->latest('created_at')->paginate(15);

        return view(config('support-center.admin-page-livewire-view'), [
            'categories' => $categories,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
