<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function withdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cash' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('account')
                ->withErrors($validator)
                ->withInput();
        }

        $cashRequested = $request->input('cash');

        exit($cashRequested);
    }
}
