<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'username' => 'required|min:3|max:180|unique:users,username',
            'email' => 'required|min:3|max:180|email|unique:users,email',
            'phone' => 'nullable|min:11|max:14|unique:user_details,phone',
            'farm_name' => 'required|min:3|max:180',
            'password' => 'required|min:6|confirmed',
            'account_holder_id' => 'required',
        ];
    }
}
