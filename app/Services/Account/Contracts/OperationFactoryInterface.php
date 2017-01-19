<?php

namespace App\Services\Account\Contracts;

use Illuminate\Http\Request;

interface OperationFactoryInterface
{
    /**
     * Create a Validator based on requested operation
     * @param  Request $request
     * @throws OperationNotFoundException if operation value is null or strategy class doesn't exist
     * @return Illuminate\Validation\Validator
     */
    public function getValidatorFromRequest(Request $request);

    /**
     * Create a Strategy based on requested operation
     * @param  Request $request
     * @throws OperationNotFoundException if operation value is null or strategy class doesn't exist
     * @return App\Services\Account\Contracts\AccountOperationStrategyInterface
     */
    public function getStrategyFromRequest(Request $request);
}
