<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeederHistoryRequest extends FormRequest
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
            'feeder_id' => 'required|exists:feeders,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'run_time' => 'required|numeric',
            'amount' => 'required|numeric',
            'unit' => 'required|in:kg,g',
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
