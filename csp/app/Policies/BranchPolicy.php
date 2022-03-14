<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit()
    {
        return (Auth::user()->permission==1 || Auth::user()->permission==2);
    }

    public function view()
    {
        return (Auth::user()->permission==1 || Auth::user()->permission==2);
    }

    public function create()
    {
        return (Auth::user()->permission==1 || Auth::user()->permission==2);
    }

    public function viewByStaff(){
        return Auth::user()->permission == 3;
    }
}
