<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactUsRequest extends FormRequest
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
            "name"=>"required",
            "email"=>"required|email",
            "phone"=>"required|regex:/[0-9]{11}/",
            "message"=>"required|max:700"
        ];
    }

    public function messages()
    {
        return [
            "name.required"=>"پر کردن نام الزامی است!",
            "email.required"=>"پر کردن ایمیل الزامی است!",
            "email.email"=>"لطفا یک ایمیل معتبر وارد نمایید!",
            "phone.required"=>"پر کردن تلفن همراه الزامی است.",
            "phone.regex"=>"لطفا یک تلفن همراه معتبر وارد نمایید!",
            "message.required"=> "پر کردن پیام الزامی است!",
            "message.max"=> "حداکثر :max کاراکتر مجاز است!"
        ];
    }
}
