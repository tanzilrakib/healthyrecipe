<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
         Schema::defaultStringLength(191);
         $dFilter[0]='Balanced';
         $dFilter[1]='High-Protein';
         $dFilter[2]='Low-Carb';
         $dFilter[3]='Low-Fat';
         

         $hFilter[0]='Alcohol-free';
         $hFilter[1]='Peanut-free';
         $hFilter[2]='Sugar-conscious';
         $hFilter[3]='Vegan';
         $hFilter[4]='Vegetarian';
            
         view()->share('dFilter', $dFilter);
         view()->share('hFilter', $hFilter);


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
