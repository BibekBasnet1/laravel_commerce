<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrderConfirmation extends Component
{
    /**
     * Create a new component instance.
     */

    public $userOrder;

    public function __construct($userOrder)
    {
        $this->userOrder = $userOrder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order-confirmation');
    }
}
