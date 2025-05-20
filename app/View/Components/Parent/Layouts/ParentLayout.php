<?php

namespace App\View\Components\Parent\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class ParentLayout extends Component
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
        return view('parent.layouts.parent');
    }
}
