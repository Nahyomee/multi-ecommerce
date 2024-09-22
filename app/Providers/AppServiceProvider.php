<?php

namespace App\Providers;

use App\Models\FlutterwaveSetting;
use App\Models\GeneralSetting;
use App\Models\PaystackSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)
                           ->mixedCase()
                           ->numbers()
                           ->symbols()
                           ->uncompromised();
        });

        /** Set Timezone */
        $generalSettings = GeneralSetting::first();
        Config::set('app.timezone', $generalSettings->timezone);

        /** Set Paystack */
        $paystack = PaystackSetting::first();
        Config::set('paystack.publicKey', $paystack?->public_key);
        Config::set('paystack.secretKey', $paystack?->secret_key);
        Config::set('paystack.merchantEmail', $paystack?->merchant_email);
        Config::set('paystack.paymentUrl', 'https://api.paystack.co');

         /** Set Paystack */
         $flutterwave = FlutterwaveSetting::first();
         Config::set('flutterwave.publicKey', $flutterwave?->public_key);
         Config::set('flutterwave.secretKey', $flutterwave?->secret_key);
         Config::set('flutterwave.secretHash', $flutterwave?->encryption_key);
        /** Share variable to all views */
        View::composer('*', function($view) use($generalSettings){
            $view->with('settings', $generalSettings);
        });
    }
}
