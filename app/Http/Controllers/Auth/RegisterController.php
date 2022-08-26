<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ["required"]
        ],$this->messages());
    }

    protected function messages() {
        return [
            "name.required" => "لطفا نام را پر نمایید!",
            "name.string" => "تنها رشته برای نام مجاز می باشد!",
            "name.max" => "حداکثر ۲۰۰ کاراکتر برای نام مجاز می باشد!",
            "email.required" => "لطفا ایمیل را پر نمایید!",
            "email.string" => "تنها رشته برای ایمیل مجاز است!",
            "email.max" => "حداکثر ۲۰۰ کاراکتر برای ایمیل مجاز است!",
            "email.unique" => "ایمیل قبلا استفاده شده است.",
            "password.required" => "لطفا پسوورد را پر نمایید!",
            "password.string" => "تنها رشته برای پسوورد مجاز است!",
            "password.min" => "حداقل ۸ کاراکتر برای پسوود مجاز است!",
            "password.confirmed" => "پسوورد ها با یکدیگر مطابقت ندارند!",
            "g-recaptcha-response.required" => "لطفا کپچا را تکمیل نمایید!"
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $request->session()->flash("success", "ثبت نام با موفقیت انجام شد!");
    }

}
