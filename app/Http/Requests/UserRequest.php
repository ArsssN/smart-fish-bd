<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::query()->find(request()->id);

        return [
//            'name' => 'required',
            'email' => 'required|unique:'
                . config('permission.table_names.users', 'users')
                . ',email' . ($user ? ',' . $user->id : ''),
            'username' => 'required|unique:'
                . config('permission.table_names.users', 'users')
                . ',username' . ($user ? ',' . $user->id : ''),
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable|same:password',
            'userDetails.first_name' => 'required',
            'userDetails.last_name' => 'required',
            'userDetails.farm_name' => 'required',
            'userDetails.phone' => 'required|unique:user_details'
                . ',phone' . ($user && $user->userDetails ? ',' . $user->userDetails->id : ''),
            'userDetails.address' => 'required',
            'userDetails.photo' => 'required',
            'userDetails.n_id_photos' => 'required',
            'userDetails.account_holder_id' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
