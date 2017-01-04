<?php

namespace App\Services\Account;

use Illuminate\Support\Facades\Validator;

interface AccountOperationInterface
{
    public function hasValidData(Request $request);

    public function processOperation(
        Request $request,
        AccountValidator $validator
        AccountStrategy $strategy
    );
}
