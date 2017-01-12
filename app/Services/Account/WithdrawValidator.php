<?php

namespace App\Services\Account;

use App\Services\Account\Contracts\OperationValidatorInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class WithdrawValidator implements OperationValidatorInterface
{
    use \App\Services\Account\Traits\ValidatorTrait;
}
