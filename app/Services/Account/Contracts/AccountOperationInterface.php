<?php

namespace App\Services\Account\Contracts;

use Illuminate\Support\Facades\Validator;

interface AccountOperationInterface
{
    /**
     * @return Illuminate\Validation\Validator
     */
    public function getValidator();

    /**
     * [hasValidData Uses validator to check requested data]
     * @return boolean
     */
    public function hasValidData();

    /**
     * [processOperation execute requested operation]
     * @return [type] [description]
     */
    public function processOperation();
}
