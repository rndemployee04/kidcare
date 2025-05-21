<?php

namespace App\View\Components\Carebuddy\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Carebuddy extends Component
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
    public function render(): View
    {
        return view('carebuddy.layouts.carebuddy');
    }
}
