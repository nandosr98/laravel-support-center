<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Tickets;

use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $tickets = BaseSupportTicket::query()->with('user')
            ->latest('created_at')
            ->paginate(15);

        return view(config('support-center.admin-page-livewire-view'), [
            'tickets' => $tickets,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
