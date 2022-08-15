<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
            'name' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'پر کردن نام ژانر ضروری است!',
            'name.max' => 'نام ژانر حدااکثر می تواند ۵۰ کاراکتر باشد!',
        ];
    }
}
