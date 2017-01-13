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
            ],
            $this->customizedMessages()
        );
    }

    /**
     * [customizedMessages]
     * @return array customizes messages for validator
     */
    private function customizedMessages()
    {
        return [
            'numeric' => 'The :attribute must be a number and display this format sample 340.00',
        ];
    }
}
