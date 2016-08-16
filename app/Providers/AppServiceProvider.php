<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\SchoolClass;

use Validator;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('ownsclass', function($attribute, $value, $parameters, $validator) {
            $result = SchoolClass::where('id', $value)
                ->where('user_id', Auth::user()->id)
                ->count();

            if ($result > 0) {
                return true;
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
