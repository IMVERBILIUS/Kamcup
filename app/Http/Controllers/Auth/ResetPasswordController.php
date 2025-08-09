<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    // Menampilkan form untuk reset password (halaman input email)
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Kirim link reset password melalui email
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Kirim email reset
        $response = Password::sendResetLink($request->only('email'));

        // Cek apakah berhasil mengirim email
        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Link reset password telah dikirim ke email Anda');
        } else {
            return back()->withErrors(['email' => 'Gagal mengirim email reset']);
        }
    }

    // Menampilkan form untuk reset password dengan token
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Proses reset password setelah memasukkan password baru
    public function reset(Request $request)
    {
        // Validasi input form
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        // Reset password menggunakan token
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => md5($password),
                ])->save();

                // Hapus token reset dari database
                DB::table('password_resets')->where('email', $user->email)->delete();
            }
        );

        // Cek apakah berhasil melakukan reset
        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password Anda telah berhasil diubah');
        } else {
            return back()->withErrors(['email' => 'Gagal mereset password']);
        }
    }
}
