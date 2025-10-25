<?php

namespace LaravelSupportCenter\Http\Controllers;

use Illuminate\Http\Request;
use LaravelSupportCenter\Models\BaseSupportTicket;

class SupportController
{
    public function create()
    {
        return view('support-center::support.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'file|max:2048',
        ]);

        $ticket = BaseSupportTicket::create($validated);

        foreach ($request->file('attachments', []) as $file) {
            $ticket->addMedia($file)->toMediaCollection('attachments');
        }

        return redirect()->back()->with('success', 'Tu solicitud ha sido enviada correctamente.');
    }

    public function support()
    {
        return view('laravel-support-center::support.user-page');
    }
}
