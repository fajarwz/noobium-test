<?php

namespace App\Http\Requests\Me\Profile;

use App\Traits\ErrorResponseJson;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'picture' => 'nullable|image|mimes:jpg,jpeg,bmp,png',
        ];
    }
}
