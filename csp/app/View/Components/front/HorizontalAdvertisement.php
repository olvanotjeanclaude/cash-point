<?php

namespace App\View\Components\front;

use Illuminate\View\Component;

class HorizontalAdvertisement extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $advertisement;
    public $image;

    public function __construct($advertisement,$image)
    {
        $this->advertisement =$advertisement;
        $this->image=$image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front.horizontal-advertisement');
    }
}
