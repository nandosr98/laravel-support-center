<?php

namespace LaravelSupportCenter\Livewire\UserPage;

use Illuminate\Validation\Rule;
use LaravelSupportCenter\Models\BaseSupportCategory;
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
    public $categories;
    public $attachments = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => [
                Rule::in($this->categories->pluck('name')->toArray()),
            ],
            'description' => 'required|string',
            'attachments.*' => 'file|max:2048',
        ];
    }

    public function mount() {

        $this->categories = BaseSupportCategory::all();

    }
    public function render()
    {

        return view(config('support-center.user-page-livewire-view'), [
            'categories' => $this->categories,
        ])
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
