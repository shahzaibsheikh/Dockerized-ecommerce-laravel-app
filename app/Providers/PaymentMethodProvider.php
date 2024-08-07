<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\PaymentServices\NewPayPal;
// use Illuminate\Http\Request;
class PaymentMethodProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
            //  var_dump(new \App\PaymentServices\PayPal(51234));exit;
        $this->app->bind(NewPayPal::class, function($app){

            return new NewPayPal("transactionid:".rand(0,1200));
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    // public function boot()
    // {
       
    // }
}
