<?php

namespace App\View\Components\branch;

use Illuminate\View\Component;

class UserBranch extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $branchs;
    public function __construct($branchs)
    {
        $this->branchs=$branchs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.branch.user-branch');
    }
}
