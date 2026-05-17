<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Tickets;

use Illuminate\Support\Facades\Log;
use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $selectedTicket = null;

    public function render()
    {
        $tickets = BaseSupportTicket::query()->with('user')
            ->latest('created_at')
            ->paginate(15);

        return view('laravel-support-center::livewire.tickets.index', [
            'tickets' => $tickets,
        ])->layout(config('support-center.admin-page-layout'));
    }

    public function viewTicket($ticketId)
    {
        $ticket = BaseSupportTicket::find($ticketId);
        if(!$ticket) {
            toast()->danger('Ticket No encontrado')->push();

        }

        $this->selectedTicket = $ticket;
    }
}
