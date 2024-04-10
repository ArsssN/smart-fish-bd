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
        $projectInlineCreateRoutes = ['project-inline-create', 'project-inline-create-save'];
        $isProjectInlineCreate = in_array(request()->route()->getName(), $projectInlineCreateRoutes);

        $pond = $isProjectInlineCreate ? 'nullable|array' : 'required|array';

        return [
            'name' => 'required|min:5|max:180',
            'status' => 'required|in:active,inactive',
            /*'sensors' => 'required|array',
            'aerators' => 'required|array',
            'feeders' => 'required|array',*/
            'ponds' => $pond,
            /*'sensors.*' => 'required|exists:sensors,id',
            'aerators.*' => 'required|exists:aerators,id',
            'feeders.*' => 'required|exists:feeders,id',*/
            'customer_id' => 'required|exists:users,id',
            'description' => 'nullable|string|max:500',
            'gateway_name' => 'required|string|max:180',
            'gateway_serial_number' => 'required|string|max:180',
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
