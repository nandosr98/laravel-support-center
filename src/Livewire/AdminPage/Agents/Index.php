<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Agents;

use LaravelSupportCenter\Models\BaseSupportAgent;
use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $agents = BaseSupportAgent::query()->with('user')
            ->latest('created_at')
            ->paginate(15);

        return view(config('support-center.admin-page-livewire-view'), [
            'agents' => $agents,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
