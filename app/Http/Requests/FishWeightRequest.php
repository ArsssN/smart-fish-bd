<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FishWeightRequest extends FormRequest
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
            'fish_id' => 'required|exists:fishes,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'weight' => 'required|numeric|min:0|max:9999999999',
            'weight_in_24_hours' => 'required|numeric|min:0|max:9999999999',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:500'
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
