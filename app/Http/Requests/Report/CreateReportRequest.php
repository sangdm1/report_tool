<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\FormRequest;

class CreateReportRequest extends FormRequest
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
            'user_id' => [
                'required',
                'numeric',
                'exists:users,id,deleted_at,NULL'
            ],
            'project_id' => [
                'required',
                'numeric',
                'exists:projects,id,deleted_at,NULL'
            ],
            'title' => [
                'required',
                'max:500',
                'string'
            ],
            'content' => [
                'array',
                'required'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => __('Id thành viên'),
            'project_id' => __('Id dự án'),
            'title' => __('Tiêu đề báo cáo'),
            'content' => 'Nội dung báo cáo'
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
            'member.*.exists' => __(':attribute không tồn tại'),
            'string' =>  __(':attribute phải là văn bản'),
            'array' => __(':attribute phải là mảng')
        ];
    }
}
