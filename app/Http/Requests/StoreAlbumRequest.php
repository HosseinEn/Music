<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
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
            'slug' => 'unique:albums',
            'cover' => 'required|image|mimes:jpeg,jpg,png,gif',
            'song' => 'mimes:mp3,mp4',
            'released_date' => 'required|date',
            'artist_id' => 'exists:artists,id|required',
            'duration'=>'required'
//            'song' => 'required|mimes:mp3,mp4'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'پر کردن نام آلبوم ضروری است!',
            'slug.unique' => 'اسلاگ تکراری است و قبلا استفاده شده است!',
            'name.max' => 'نام آلبوم حدااکثر می تواند ۵۰ کاراکتر باشد!',
            'cover.image' => 'فایل انتخاب شده یک تصویر نمی باشد!',
            'cover.mimes' => 'تصویر انتخاب شده باید پسوند مجاز داشته باشد. (jpg, jpeg, png)',
            'cover.required'=>'افزودن کاور برای آلبوم اجباری است!',
            'song.mimes' =>'موسیقی باید پسوند mp3 یا mp4 داشته باشد!',
            'released_date.required' => 'تاریخ انتشار را انتخاب نمایید!',
            'released_date.date' => 'تاریخ را به درستی وارد نمایید!',
            'artist_id.required'=> 'یک هنرمند را انتخاب نمایید!',
            'artist_id.exists' => 'یک هنرمند را از لیست انتخاب نمایید!',
            'duration.required' => 'طول زمانی آلبوم را وارد نمایید!'
        ];
    }
}
