<?php

namespace LaravelSupportCenter\Livewire\UserPage;

use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithFileUploads;


class BaseSupportUserPage extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $subject;
    public $description;
    public $attachments = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'attachments.*' => 'file|max:2048',
    ];

    public function render()
    {
        return view(config('support-center.user-page-livewire-view'), [])
            ->layout(config('support-center.user-page-layout'));
    }

    public function submit()
    {
        $this->validate($this->rules);

        $ticket = BaseSupportTicket::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'description' => $this->description,
        ]);


        foreach ($this->attachments as $file) {
            $ticket->addMedia($file->getRealPath())
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('attachments');
        }

        $this->reset(['subject', 'description', 'attachments']);
        session()->flash('success', 'Tu solicitud ha sido enviada correctamente.');
    }
}
