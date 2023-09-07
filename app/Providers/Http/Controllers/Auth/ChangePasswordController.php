<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return inertia()->render('Auth/Dashboard/ChangePassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6|max:15|string',
            'redirect' => 'nullable|string'
        ], [
            'password.required' => 'يجب ادخال كلمة المرور',
            'password.confirm' => 'يجب تطابق كلمة المرور',
            'password.min' => 'يجب ان تكون كلمة المرور اكثر من 6 احرف',
            'password.max' => 'يجب ان يكون اقل من 15 حرف'
        ]);

        $user = User::find(Auth::id());
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
                'tmp_password' => null,
            ]);
            if ($request->redirect != null) {
                return redirect($request->redirect);
            }
            return redirect('/');
        } else {
            return redirect('/login');
        }
    }
}
