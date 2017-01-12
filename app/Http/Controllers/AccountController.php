<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Account\Contracts\AccountOperationInterface;

class AccountController extends Controller
{
    /**
    * Show the form to withdraw cash
    * @return Response
    */
    public function showWithdrawForm()
    {
        return view('withdrawCashForm');
    }

    /**
    * Process withdraw request
    * @param Request $request
    * @return Response
    */
    public function withdraw(Request $request, AccountOperationInterface $accountOperation) {

        if (! $accountOperation->hasValidData()) {
            return redirect('account')
                ->withErrors($accountOperation->getValidator())
                ->withInput();
        }

        return $accountOperation->processOperation($request);
    }
}
