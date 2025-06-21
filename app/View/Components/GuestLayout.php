<?php

namespace App\View\Components;

use Closure;
use App\Models\Setting;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class GuestLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $website = Setting::first();
        return view('components.layouts.guest-layout', compact("website"));
    }
}
