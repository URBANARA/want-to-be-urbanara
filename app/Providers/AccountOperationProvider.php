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
        $this->app->bind(
            'App\\Services\\Account\\AccountOperationInterface',
            'App\\Services\\Account\\WithdrawAccountOperationService'
        );

        // $this->app->when(AccountController::class)
        //   ->needs(AccountOperationInterface::class)
        //   ->give(function () {
        //       return App\\Services\\Account\\WithdrawAccountOperationService();
        //   });
    }
}
