<?php

namespace App\Http\Controllers\Auth\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }
        $props = $request->validate([
            'user_name' => 'nullable|exsit:users,user_name',
            'redirect' => 'nullable|string',
        ]);
        return inertia()->render('Auth/Dashboard/Login', $props);
    }

    public function store(Request $request)
    {
        $props = $request->validate([
            'user_name' => 'required|exists:users,user_name',
            'password' => 'required',
            'remember' => 'nullable|boolean',
            'redirect' => 'nullable|string',
        ], [
            'user_name.required' => 'يجب ادخال اسم المستخدم',
            'user_name.exists' => 'اسم المستخدم غير صحيح',
            'password.required' => 'يجب ادخال كلمة المرور',
        ]);

        $user = User::where('user_name', $props['user_name'])->first();

        if (!Hash::check($props['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'كلمة المرور غير متطابقة.',
            ]);
        }

        if (auth()->attempt($props)) {
            if ($request->redirect)
                return redirect($request->redirect);
            return redirect('/');
        }
        return back()->withErrors([
            'user_name' => 'اسم المستخدم غير صحيح',
        ]);
    }

    public function forgatePasswordIndex()
    {
        return inertia()->render('Auth/Dashboard/ForgatePassword');
    }

    public function forgatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::query()->where('email', $request->get('email'));

        $tmpPassword =  Str::random(6);

        if (Mail::to($request->email)->send(new ResetPassword($tmpPassword))) {
            $user->update([
                'tmp_password' => Hash::make($tmpPassword),
                'password' => Hash::make($tmpPassword),
            ]);
            return redirect('/');
        }

        return back()->withErrors([
            'message' => 'حدث خطاء معين الرجاء المحاولة لاحقا!'
        ]);
    }
}
