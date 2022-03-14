<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CustomPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      $this->setUserPermission();
      $this->setUserType();
    }

    private function setUserType(){
        Blade::if('userType', function ($value) {
             return Auth::user()->permission == $value;
        });
    }

    private function setUserPermission(){
        Blade::if('userPermission', function ($value) {
            $userPermission = false;

            switch ($value) {
                case '1':
                    $userPermission = Auth::user()->permission == 1;
                    break;
                case '2':
                    $userPermission = (Auth::user()->permission == 1 ||  Auth::user()->permission == 2);
                    break;
                case '3':
                    $userPermission = (Auth::user()->permission == 1 || Auth::user()->permission == 2 ||  Auth::user()->permission == 3);
                    break;
                case '4':
                    $userPermission = Auth::user()->permission == 1 || Auth::user()->permission == 2 ||  Auth::user()->permission == 3 || Auth::user()->permission == 4;
                    break;

                default:
                    $userPermission = false;
                    break;
            }
            return $userPermission;
        });
    }
}
