<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class OtpVerificationController extends Controller
{
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        // Retrieve the user's email from the session
        $userEmail = session('user_email');

        if (!$userEmail) {
            return redirect()->route('register')->withErrors(['error' => 'Session expired. Please register again.']);
        }

        // Find the user by email and verify the OTP
        $user = User::where('email', $userEmail)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Clear OTP fields and session data after successful verification
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now(), // Mark email as verified
        ]);
        session()->forget('user_email');

        // Log the user in
        Auth::login($user);

        return redirect('/home')->with('status', 'Your account has been verified successfully!');
    }
}
