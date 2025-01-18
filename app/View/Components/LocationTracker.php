<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LocationTracker extends Component
{
    public $shift;

    public function __construct($shift)
    {
        $this->shift = $shift;
    }

    public function render()
    {
        return view('components.location-tracker');
    }
}