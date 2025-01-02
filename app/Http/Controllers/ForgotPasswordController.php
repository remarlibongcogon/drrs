<?php

namespace App\Http\Controllers;

use App\Services\PHPMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    protected $mailer;

    public function __construct(PHPMailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function index(){
        return view('pages.auth.forgot_password.email');
    }

    public function forgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,emailaddress',
        ]);

        if ($validator->fails()) {
            return back()->with('error', implode('<br>', $validator->errors()->all()));
        }

        $token = Str::random(64);

        // store token in the password_resets table
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Prepare email content
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);
        $subject = 'Reset Your Password';
        $body = "
            <p>Hi,</p>
            <p>Click the link below to reset your password:</p>
            <a href='{$resetLink}'>Reset Password</a>
            <p>If you did not request a password reset, no further action is required.</p>
        ";
        
        $result = $this->mailer->sendMail($request->email, $subject, $body);

        if ($result === true) {
            return back()->with('success', 'Password reset email sent successfully.');
        } else {
            return back()->with('error', $result);
        }
    }

    public function showResetForm(Request $request, $token)
    {
        return view('pages.auth.forgot_password.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users,emailaddress',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Invalid or expired password reset token.');
        }

        DB::table('users')
            ->where('emailaddress', $request->email)
            ->update([
                'password' => Hash::make($request->password),
            ]);

        // dlete the reset token after successful password reset
        DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->delete();

        return redirect()->route('loginPage')->with('success', 'Your password has been reset successfully!');
    }
}
