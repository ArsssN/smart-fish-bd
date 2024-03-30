<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SwitchUnitRequest extends FormRequest
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
            'name' => 'required|string|max:180',
            'serial_number' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'switches' => 'required|array',
            'switches.*.number' => 'required|integer',
            'switches.*.switchType' => 'required|exists:switch_types,id',
            'switches.*.status' => 'required|in:on,off',
            'switches.*.comment' => 'nullable|string',
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
