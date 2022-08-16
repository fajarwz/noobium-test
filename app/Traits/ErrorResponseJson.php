<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ErrorResponseJson
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'meta' => [
                        'code' => 422,
                        'status' => 'error',
                        'message' => $validator->errors(),
                    ],
                    'data' => [],
                ], 422
            ));
    }
}
