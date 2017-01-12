<?php

namespace App\Services\Account\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

Trait ValidatorTrait
{
    /**
     * Creates a default validator
     * @param  Request $request
     * @return Illuminate\Support\Facades\Validator
     */
    public function resolveValidator(Request $request)
    {
        return Validator::make($request->all(), [
            'operation' => 'required',
            'cash'      => 'required|numeric',
        ]);
    }
}
