<?php

namespace LaravelSupportCenter\Livewire\UserPage;

use Illuminate\Validation\Rule;
use LaravelSupportCenter\Models\BaseSupportCategory;
use LaravelSupportCenter\Models\BaseSupportTicket;
use Livewire\Component;
use Livewire\WithFileUploads;


class BaseSupportThreadPage extends Component
{
    use WithFileUploads;

    public $ticket;

    protected function rules(): array
    {

    }

    public function mount($uuid) {

        $ticket = BaseSupportTicket::where('uuid', $uuid)->firstOrFail();
        $this->ticket = $ticket;

    }
    public function render()
    {

        return view(config('support-center.user-page-thread-livewire-view'), [])
            ->layout(config('support-center.user-page-layout'));
    }

    public function submit()
    {
        $this->validate();

        $ticket = BaseSupportTicket::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'description' => $this->description,
        ]);


        foreach ($this->attachments as $file) {
            $ticket->addMedia($file->getRealPath())
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection(config('support-center.media_collection'));
        }

        $this->reset(['subject', 'description', 'attachments']);
        session()->flash('success', 'Tu solicitud ha sido enviada correctamente.');
    }
}
