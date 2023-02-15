<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\FormRequest;

class CreateProjectRequest extends FormRequest
{
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
            'name' => [
                'required',
                'max:255',
            ],
            'start_at' => [
                'required',
                'date_format:Y-m-d',
            ],
            'end_at' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:start_at',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('label.projects.name'),
            'end_at' => __('label.projects.end_at'),
            'start_at' => __('label.projects.start_at'),

        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'required' => __('messages.MSG_001'),
            'numeric' => __('messages.MSG_002'),
            'date_format' => __('messages.MSG_003'),
            'after_or_equal' => __('messages.MSG_004', ['attributeFrom' => __('label.projects.start_at')]),
            'max' => __('messages.MSG_003'),
        ];
    }
}
