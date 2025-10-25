<?php

namespace LaravelSupportCenter\Livewire\UserPage;

use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithFileUploads;


class Index extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $subject;
    public $message;
    public $attachments = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'attachments.*' => 'file|max:2048',
    ];

    public function render()
    {
        return view(config('support.user-page-livewire-view'), [
            'parameters' => 'Parameter'
        ])->layout(config('support.user-page-layout'));
    }

    public function submit()
    {
        $this->validate();

        $ticket = BaseSupportTicket::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);


        foreach ($this->attachments as $file) {
            $ticket->addMedia($file->getRealPath())
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('attachments');
        }


        $this->reset(['subject', 'message', 'attachments']);
        session()->flash('success', 'Tu solicitud ha sido enviada correctamente.');
    }
}
