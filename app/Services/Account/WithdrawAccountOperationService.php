<?php

namespace App\Services\Account;

use Illuminate\Support\Facades\Validator;
use App\Services\Account\AccountOperationInterface;
use Illuminate\Http\Request;

class WithdrawAccountOperationService implements AccountOperationInterface
{
    public function processOperation(
        Request $request
    ) {
        $validator = Validator::make($request->all(), [
            'cash' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('account')
                ->withErrors($validator)
                ->withInput();
        }

        return $request->input('cash');
    }
}
