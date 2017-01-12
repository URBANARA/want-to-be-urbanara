<?php

namespace App\Services\Account;

use App\Services\Account\Contracts\AccountOperationStrategyInterface;
use Illuminate\Http\Request;

class WithdrawAccountOperationStrategy implements AccountOperationStrategyInterface
{
    /**
     * Index to accesss cash value from Request
     * @var string
     */
    const REQUEST_CASH_INDEX = 'cash';

    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * [__construct]
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * [processOperation Execute the operation requested by user]
     * @return [type] [description]
     */
    public function processOperation()
    {
        return $this->request->input(self::REQUEST_CASH_INDEX);
    }
}
