<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
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
            'slug' => 'unique:artists',
            'image' => 'image|mimes:jpeg,jpg,png,gif'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'پر کردن نام هنرمند ضروری است!',
            'slug.unique' => 'اسلاگ تکراری است و قبلا استفاده شده است!',
            'name.max' => 'نام هنرمند حدااکثر می تواند ۵۰ کاراکتر باشد!',
            'image.image' => 'فایل انتخاب شده یک تصویر نمی باشد!',
            'image.mimes' => 'تصویر انتخاب شده باید پسوند مجاز داشته باشد. (jpg, jpeg, png)'
        ];
    }
}
