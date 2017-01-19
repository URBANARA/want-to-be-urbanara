<?php

namespace App\Services\Account;

use App\Services\Account\Contracts\OperationFactoryInterface;
use App\Services\Account\Exceptions\OperationNotFoundException;
use App\Services\Account\AvailableBankNotes;
use Illuminate\Http\Request;

class OperationFactory implements OperationFactoryInterface
{
    /**
     * Index for operantion input inside request
     * @var string
     */
    const OPERATION_INDEX = 'operation';

    /**
     * Validator default
     * @var string
     */
    const DEFAULT_VALIDATOR = 'default';

    /**
     * Create a Validator based on requested operation
     * @param  Request $request
     * @throws OperationNotFoundException if operation value is null or strategy class doesn't exist
     * @return Illuminate\Validation\Validator
     */
    public function getValidatorFromRequest(Request $request)
    {
        $operation = $request->input(self::OPERATION_INDEX)
            ? $request->input(self::OPERATION_INDEX)
            : self::DEFAULT_VALIDATOR;

        $fullClassNameStrategy = 'App\Services\Account\\' . ucwords($operation) . 'Validator';

        if (class_exists($fullClassNameStrategy)) {
            $validator = new $fullClassNameStrategy();

            return $validator->resolveValidator($request);
        }

        // Should never arrive here: search for "Dead programs tell no lies"
        throw new OperationNotFoundException("The requested operation was not found");
    }

    /**
     * Create a Strategy based on requested operation
     * @param  Request $request
     * @throws OperationNotFoundException if operation value is null or strategy class doesn't exist
     * @return App\Services\Account\Contracts\AccountOperationStrategyInterface
     */
    public function getStrategyFromRequest(Request $request)
    {
        if (! $operation = $request->input(self::OPERATION_INDEX)) {
            throw new OperationNotFoundException("The requested operation can not be null");
        }

        $fullClassNameStrategy = 'App\Services\Account\\' . ucwords($operation) . 'AccountOperationStrategy';

        if (class_exists($fullClassNameStrategy)) {
            return new $fullClassNameStrategy($request, new AvailableBankNotes());
        }

        throw new OperationNotFoundException("The requested operation was not found");
    }

}
