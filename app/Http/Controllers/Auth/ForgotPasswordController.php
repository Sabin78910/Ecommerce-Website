<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate a random OTP
        $otp = rand(100000, 999999);

        // Find the user and update OTP and its expiry time
        $user = User::where('email', $request->email)->first();
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10); // OTP valid for 10 minutes
        $user->save();

        // Send the OTP via email
        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your Password Reset OTP');
            });

            // Redirect to another page with a success message
            return view('auth.passwords.reset')->with('success', 'OTP has been sent to your email.');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['email' => 'Failed to send OTP. Please try again later.']);
        }
    }

    public function verifyOtp(Request $request)
    {
        // Validate the OTP
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        // Verify OTP and expiry
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return redirect()->back()->withErrors(['email' => 'Invalid or expired OTP. Please try again.']);
        }

        // Allow user to reset password
        return  redirect()->route('forgot-password.reset-password')->with('success', 'OTP has been verified. You can now reset your password.');
    }


    public function resetPassword(Request $request)
    {
        // Validate the new password
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email does not exist.']);
        }

        // Reset the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password has been reset successfully.');
    }


    public function reset_email()
    {
        return view('auth.passwords.email');
    }

    public function reset_password_form()
    {
        return view('auth.passwords.confirm');
    }
}
