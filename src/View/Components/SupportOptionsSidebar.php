<?php

namespace LaravelSupportCenter\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SupportOptionsSidebar extends Component
{
    public function render(): View
    {
        return view('laravel-support-center::components.support-options-sidebar');
    }
}
