<?php

namespace App\Services\Account\Contracts;

use Illuminate\Http\Request;

interface AccountOperationStrategyInterface
{
    /**
     * [processOperation Execute the operation requested by user]
     * @return [type] [description]
     */
    public function processOperation();
}
