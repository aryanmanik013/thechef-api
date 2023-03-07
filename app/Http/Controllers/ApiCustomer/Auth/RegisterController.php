<?php

namespace App\Http\Controllers\ApiCustomer\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Register;
use App\Model\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     */

    public function register(Request $request)
    {
        //  dd($request->all());
        file_put_contents('register_customer.txt', "");
        error_log(json_encode($request->all()), 3, 'register_customer.txt');
        $verification_otp = rand(100000, 999999);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:customers',
            'phone' => 'required|max:12|unique:customers',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new Customer([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'verification_otp' => $verification_otp,
        ]);

        $user->save();
        // SmsHelper::send($request->phone,'GheeRice Verification OTP is '. $verification_otp);

        Mail::to($user->email, 'Ghee Rice App')->send(new Register($user));

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::guard('customer')->user();
        }

        $tokenResult = $user->createToken('TNMAutoHub');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'verification_otp' => $verification_otp,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'message' => 'User has been successfully created!',
        ], 201);

        /* return response()->json([
    'message' => 'User has been successfully created!'
    ], 201);  */

    }
}
