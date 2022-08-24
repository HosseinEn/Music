<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const PAGINATEDBY = 10;

    public function __construct() {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageNumberMultiplyPaginationSize = $this->calculateCounter($request->query('page'));

        if($request->has('search')) {
            $searchParam = $request->get('search');
            $users = User::where('name', 'like', "%{$searchParam}%")
                           ->orWhere('email', 'like', "%{$searchParam}%")
                           ->paginate(self::PAGINATEDBY);
        }
        else {
            $users = User::orderBy("created_at", "desc")->paginate(self::PAGINATEDBY);
        }
        return view("users.index", compact(["users", "pageNumberMultiplyPaginationSize"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::denies('edit-admin', $user)) {
            return redirect()->back()->with('error', "ویرایش ادمین امکان پذیر نمی باشد!");
        }
        return view('users.edit', compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required",
            "email" => ["required", "email", Rule::unique('users')->ignore($user->id)]
        ], $this->messages());
        $user->update($request->all());
        return redirect(route('users.index'))->with("success", "کاربر با موفقیت ویرایش شد");
    }

    public function messages() {
        return [
            "name.required" => "نام اجباری است!",
            "email.required" => "ایمیل اجباری است!",
            "email.email" => "لطفا ایمیل معتبر وارد نمایید!",
            "email.unique"=>"ایمیل تکراری است!"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Gate::denies('delete-admin', $user)) {
            return redirect()->back()->with('error', "حذف ادمین امکان پذیر نمی باشد!");
        }
        $user->delete();
        return redirect()->back()->with('success', "کاربر با موفقیت حذف گردید!");
    }
}
