<?php

namespace App\Services\Account\Contracts;

use Illuminate\Http\Request;

interface OperationValidatorInterface
{
    public function resolveValidator(Request $request);
}
