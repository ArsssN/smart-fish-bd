<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UserDetailsAPIRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = auth()->user();

        return [
            'first_name' => 'nullable|min:3|max:191',
            'last_name' => 'nullable|min:3|max:191',
            'farm_name' => 'nullable|min:3|max:191',
            'phone' => 'nullable|min:11|max:14|unique:user_details,phone,' . $user->id . ',user_id',
//            'phone' => 'nullable|min:11|max:14',
            'address' => 'nullable|min:3|max:191',
//            'n_id_photos' => 'nullable|min:3|max:191',
//            'account_holder_id' => 'nullable|min:3|max:191',
//            'password' => 'nullable|password|confirmed|min:6',
//            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
