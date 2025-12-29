<?php

namespace LaravelSupportCenter\Livewire\AdminPage\Tickets;

use LaravelSupportCenter\Models\BaseSupportTicket;

class ViewTicket
{
    public BaseSupportTicket|int $ticket;
    public function mount($ticket)
    {
        $this->ticket = $ticket;
    }
    public function render()
    {
        $ticket = BaseSupportTicket::find($this->ticket)->with('user');
        if( !$ticket ) {
            toast()->danger('Ticket No encontrado')->push();
            return redirect()->route('support.admin-page.tickets');
        }

        return view('laravel-support-center::livewire.tickets.view', [
            'ticket' => $ticket,
        ])->layout(config('support-center.admin-page-layout'));
    }

}
