<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AccountOperationProvider extends ServiceProvider
{
    /**
     * Register AccountOperationProvider class with the Laravel IoC container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Services\Account\AccountOperationService')
          ->needs('App\Services\Account\Contracts\OperationFactoryInterface')
          ->give(function () {
              return new \App\Services\Account\OperationFactory();
          });

        $this->app->bind(
            'App\Services\Account\Contracts\AccountOperationInterface',
            'App\Services\Account\AccountOperationService'
        );
    }
}
