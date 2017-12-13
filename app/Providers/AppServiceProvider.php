<?php

namespace App\Providers;

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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Billing\PlaceToPayPaymentGateway::class, function () {
            return new \App\Billing\PlaceToPayPaymentGateway([
                'login' => config('services.placetopay.login'),
                'tranKey' => config('services.placetopay.tranKey')
            ]);
        });

        $this->app->bind(\App\Billing\PaymentGateway::class, \App\Billing\PlaceToPayPaymentGateway::class);
    }
}
