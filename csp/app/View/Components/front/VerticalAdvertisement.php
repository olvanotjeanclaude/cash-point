<?php

namespace App\View\Components\front;

use Illuminate\View\Component;

class VerticalAdvertisement extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $advertisement;
    public $image;
    public $responsive;

    public function __construct($responsive, $advertisement, $image)
    {
        $this->advertisement = $advertisement;
        $this->image = $image;
        $this->responsive = $responsive;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front.vertical-advertisement');
    }
}
