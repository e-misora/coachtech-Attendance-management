<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'finish_work_time' => ['after:start_work_time'],
            'remarks' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'finish_work_time.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'remarks.required' => '備考を記入してください'
        ];
    }
}
