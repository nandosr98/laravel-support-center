<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Tags;

use LaravelSupportCenter\Models\BaseSupportAgent;
use LaravelSupportCenter\Models\BaseSupportCategory;
use LaravelSupportCenter\Models\BaseSupportTag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $tags = BaseSupportTag::query()->latest('created_at')->paginate(15);

        return view(config('support-center.admin-page-tag-livewire-view'), [
            'tags' => $tags,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
