<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        return [
            'name' => 'required|min:5|max:180',
            'status' => 'required|in:active,inactive',
            'sensors' => 'required|array',
            'aerators' => 'required|array',
            'feeders' => 'required|array',
            /*'sensors.*' => 'required|exists:sensors,id',
            'aerators.*' => 'required|exists:aerators,id',
            'feeders.*' => 'required|exists:feeders,id',*/
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string|max:500',
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
