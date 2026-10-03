<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'string', 'regex:/^\+?[1-9]\d{1,14}$/', 'unique:users'],
        ]);
    }

    protected function create(array $data)
    {
        $otp = random_int(100000, 999999);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(30),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Send OTP to user via email or SMS
        $this->sendOtp($user);

        // Store the user's email in the session
        session(['user_email' => $user->email]);

        return redirect()->route('verify.otp')->with('status', 'An OTP has been sent to your email/mobile.');
    }

    protected function sendOtp($user)
    {
        // Example of sending OTP via email
        Mail::send('emails.verify-otp', ['otp' => $user->otp], function ($message) use ($user) {
            $message->to($user->email)->subject('Your OTP Verification Code');
        });

        // Alternatively, you can integrate SMS APIs like Twilio for mobile OTP
    }

    // Resend OTP method
    public function resendOtp(Request $request)
    {
        // Retrieve the user's email from the session
        $userEmail = session('user_email');

        if (!$userEmail) {
            return redirect()->route('register')->withErrors(['error' => 'Session expired. Please register again.']);
        }

        // Find the user by email
        $user = User::where('email', $userEmail)->first();

        if (!$user) {
            return redirect()->route('register')->withErrors(['error' => 'User not found. Please register again.']);
        }

        // Generate a new OTP and update the database
        $newOtp = random_int(100000, 999999);
        $user->update([
            'otp' => $newOtp,
            'otp_expires_at' => now()->addMinutes(30),
        ]);

        // Resend the OTP
        $this->sendOtp($user);

        return back()->with('status', 'A new OTP has been sent to your email/mobile.');
    }
}
