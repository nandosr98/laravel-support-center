<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Tickets;

use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;

class ViewTicket extends Component
{
    public BaseSupportTicket|int $ticket;
    public function mount($ticket)
    {
        $this->ticket = $ticket;
    }
    public function render()
    {
        $ticket = BaseSupportTicket::find($this->ticket)->with('user')->first();
        if( !$ticket ) {
            toast()->danger('Ticket No encontrado')->push();
            return redirect()->route('support.admin-page.tickets');
        }
        $this->ticket = $ticket;

        return view('laravel-support-center::livewire.tickets.view', [
            'ticket' => $this->ticket,
        ])->layout(config('support-center.admin-page-layout'));
    }

}
