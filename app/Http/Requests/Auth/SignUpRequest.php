<?php

namespace App\Http\Requests\Auth;

use App\Traits\ErrorResponseJson;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    use ErrorResponseJson;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:190',
            'email' => 'required|string|email:rfc,dns|max:190|unique:users',
            'password' => 'required|string|min:6|max:190',
        ];
    }
}
