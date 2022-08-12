<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSongRequest extends FormRequest
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
            'name'=>'required|max:50',
            'cover' => 'image|mimes:jpeg,jpg,png,gif',
            'released_date' => 'required|date',
            'artist_id' => 'exists:artists,id|required',
            'duration'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'پر کردن نام موسیقی ضروری است!',
            'name.max' => 'نام موسیقی حدااکثر می تواند ۵۰ کاراکتر باشد!',
            'cover.image' => 'فایل انتخاب شده یک تصویر نمی باشد!',
            'cover.mimes' => 'تصویر انتخاب شده باید پسوند مجاز داشته باشد. (jpg, jpeg, png)',
            'cover.uploaded' => 'فایل تصویر به درستی آپلود نشد!',
            'released_date.required' => 'تاریخ انتشار را انتخاب نمایید!',
            'released_date.date' => 'تاریخ را به درستی وارد نمایید!',
            'artist_id.required'=> 'یک هنرمند را انتخاب نمایید!',
            'artist_id.exists' => 'یک هنرمند را از لیست انتخاب نمایید!',
            'duration.required' => 'طول زمانی را وارد نمایید!',
        ];
    }
}
