<?php

namespace App\View\Components\form;

use App\Models\Province;
use Illuminate\View\Component;

class EditAddress extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $address;
    public $provinces;

    public function __construct($address)
    {
        $this->address=$address;
        $this->provinces = Province::orderBy('province_name', "asc")->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.edit-address');
    }
}
