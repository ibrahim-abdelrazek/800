<?php

namespace App\Providers;
use DB;
use View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
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

        $AppName = DB::table('settings')->where('key' , 'Application Name')->first();
        View()->share('AppName',$AppName->value);
        
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
