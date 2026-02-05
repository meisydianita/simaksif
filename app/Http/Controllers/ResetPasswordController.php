<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        if (User::where('email', $email)->exists()) {
            $broker = 'users';
        } elseif (Anggota::where('email', $email)->exists()) {
            $broker = 'anggota';
        } else {
            return back()->withErrors(['login_error' => 'Email tidak ditemukan']);
        }

        $status = Password::broker($broker)->sendResetLink([
            'email' => $email
        ]);

        return $status === Password::ResetLinkSent
            ? back()->with(['login_success' => __($status)])
            : back()->withErrors(['login_error' => __($status)]);
    }

    public function passwordReset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = $request->email;

        if (User::where('email', $email)->exists()) {
            $broker = 'users';
            $modelClass = User::class;
        } else {
            $broker = 'anggota';
            $modelClass = Anggota::class;
        }

        $status = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($model, string $password) {
                $model->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $model->save();

                event(new PasswordReset($model));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('login_success', 'Password berhasil diubah, silakan login')
            : back()->withErrors(['email' => __($status)]);
    }
}
