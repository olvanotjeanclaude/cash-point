<?php

namespace App\View\Components\Form;

use App\Models\Province;
use Illuminate\View\Component;

class Address extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $provinces;

    public function __construct()
    {
        $this->provinces = Province::orderBy('province_name', "asc")->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.address');
    }
}
