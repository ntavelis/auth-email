<?php

namespace Ntavelis\AuthEmail;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Ntavelis\AuthEmail\Commands\AuthEmail;
use Ntavelis\AuthEmail\Repository\Activation;
use Ntavelis\AuthEmail\Repository\ActivationInterface;
use Illuminate\Support\Facades\Validator;
use Ntavelis\AuthEmail\Services\EmailAdapter;
use Ntavelis\AuthEmail\Services\Interfaces\Email;

class AuthEmailServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Better safe than sorry, check Laravel's documentation
         * https://laravel.com/docs/5.4/migrations#creating-indexes
         * for details
         */
        Schema::defaultStringLength(191);

        /**
         * Registering commands with artisan
         */
        if ($this->app->runningInConsole()) {
            $this->commands([
                AuthEmail::class,
            ]);
        }

        /**
         * Register custom Validator for alphanumeric with spaces
         */
        Validator::extend('alpha_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ActivationInterface::class,
            Activation::class
        );

        $this->app->bind(
            Email::class,
            EmailAdapter::class
        );
    }
}