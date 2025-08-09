<?php

// PasswordController.php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Kirim link reset password
        $status = \Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Password::RESET_LINK_SENT
            ? back()->with('status', __('Password reset link sent!'))
            : back()->withErrors(['email' => __('We could not find a user with that email address.')]);
    }
}
