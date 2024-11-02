<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $request->validate(
        [
            'email' => 'required|email',
            'password' => 'required',
        ]
    );

    if (Auth::attempt(
        [
            'email' => $request->email,
            'password' => $request->password,
        ],
        $request->boolean('remember')
    )) {
        // بعد تسجيل الدخول الناجح، توجيه المستخدم إلى الصفحة الرئيسية
        return redirect()->intended('/home'); // أو استخدم '/dashboard' إذا كان ذلك هو التوجيه المطلوب
    }

    return back()->withInput()->withErrors(
        [
            'email' => 'Invalid credentials.',
        ]
    );
}
        }

