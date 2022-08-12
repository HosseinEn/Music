<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArtistRequest extends FormRequest
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
            'image' => 'image|mimes:jpeg,jpg,png,gif'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'پر کردن نام هنرمند ضروری است!',
            'name.max' => 'نام هنرمند حدااکثر می تواند ۵۰ کاراکتر باشد!',
            'image.image' => 'فایل انتخاب شده یک تصویر نمی باشد!',
            'image.mimes' => 'تصویر انتخاب شده باید پسوند مجاز داشته باشد. (jpg, jpeg, png)',
            'image.uploaded' => 'فایل تصویر به درستی آپلود نشد!',
        ];
    }
}
