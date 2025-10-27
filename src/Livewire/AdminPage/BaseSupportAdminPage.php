<?php

namespace LaravelSupportCenter\Livewire\AdminPage;

use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithPagination;

class BaseSupportAdminPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $tickets = BaseSupportTicket::query()
            ->latest('created_at')
            ->paginate(config('support-center.admin-page-pagination', 15));

        return view(config('support-center.admin-page-livewire-view'), [
            'tickets' => $tickets,
        ])->layout(config('support-center.admin-page-layout'));
    }
}
