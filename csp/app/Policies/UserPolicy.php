<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function view()
    {
        return Auth::user()->permission == 1;
    }

    public function viewManagerOrStaff(){
        return Auth::user()->permission == 1 || Auth::user()->permission==2;
    }

    public function viewCustomer(){
        return Auth::user()->permission == 1 || Auth::user()->permission==2;
    }

    public function viewByStaff(){
        return Auth::user()->permission == 3;
    }
}
