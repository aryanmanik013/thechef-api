<?php

namespace App\Http\Controllers\ApiKitchen\Auth;

use App\Http\Controllers\Controller;
use App\Model\Kitchen;
use App\Model\PushNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SmsHelper;

class LoginController extends Controller
{

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        file_put_contents('login.txt', "");
        error_log(json_encode($request->all()), 3, 'login.txt');
        $kitchen = Kitchen::wherePhone($request->phone)->where('phone_prefix', $request->prefix)->first();
        if (!empty($kitchen)) {
            $credentials = ['phone' => $request->phone, 'password' => $request->phone, 'phone_prefix' => $request->prefix];
            if (!Auth::guard('kitchen')->attempt($credentials)) {
                return response()->json(['message' => 'Invalid Login Credentials'], 401);
            }
            $user = $request->user('kitchen');
            $tokenResult = $user->createToken('CHFKitchen');
            $token = $tokenResult->token;
            $token->save();
            $user->verification_otp = $verification_otp = rand(1000, 9999);
            $user->save();
            if ($user->status == 0) {
                return response()->json(['message' => 'Your account has been blocked. Please contact Admin'], 401);
            } else {
                SmsHelper::send($user->phone, 'Your verification code for The Chef Kitchen login is  ' . $user->verification_otp . '.');
                $featuredImage = $kitchen->getMedia('kitchen')->first() ? $kitchen->getMedia('kitchen')->first()->getUrl() : '';
                return response()->json([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'featuredImage' => $featuredImage,
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                    'verification_otp' => $verification_otp,
                    'user' => $user,

                    'type' => 'Login',
                ]);
            }
        } else {
            $verification_otp = rand(1000, 9999);
            $user = new Kitchen([
                'name' => $request->phone,
                'email' => $request->phone . '@thechef.com',
                'phone' => $request->phone,
                'phone_prefix' => $request->prefix,
                'password' => bcrypt($request->phone),
                'verification_otp' => $verification_otp,
            ]);
            $user->save();
            SmsHelper::send($user->phone, 'Thank you for registering with The Chef Kitchen. Please enter OTP ' . $user->verification_otp . ' to verify your account.');
            // Mail::to($user->email,'Groz App')->send(new Register($user));
            $credentials = ['phone' => $request->phone, 'password' => $request->phone, 'phone_prefix' => $request->prefix];
            if (Auth::attempt($credentials)) {
                $user = Auth::guard('kitchen')->user();
            }

            $kitchen = Kitchen::where('id', $user->id)->get();
            $featuredImage = '';
            $tokenResult = $user->createToken('CHFKitchen');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'user' => $kitchen,
                'featuredImage' => $featuredImage,
                'verification_otp' => $verification_otp,
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'message' => 'User has been successfully created!',
            ], 201);
        }
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->email(), 'password');
        $credentials = array_add($credentials, 'phone_prefix', $request->phone_prefix);
        return $credentials;
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = Kitchen::whereId($request->user('api-kitchen')->id)->first();
        return response()->json($user);
    }

    /**
     * Verify OTP .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function otpVerify(Request $request)
    {
        $kitchen = Kitchen::whereId($request->user('api-kitchen')->id)->first();
        if ($kitchen->verification_otp == $request->otp) {
            if (isset($request->type) && $request->type == 'forgotPassword') {
                $kitchen->verification_status = 0;
            } else {
                $kitchen->verification_status = 1;
            }
            $kitchen->verification_otp = 0;
            $kitchen->save();

            return response()->json(['message' => 'OTP Verification Success', 'status' => 1]);
        } else {
            return response()->json(['error' => 'OTP you have entered is Invalid.', 'status' => 0], 422);
        }
        return;
    }

    /**
     * Resend OTP.
     *
     */
    protected function resendOtp(Request $request)
    {
        //$customer = Customer::find($request->customer_id);
        $kitchen = Kitchen::whereId($request->user('api-kitchen')->id)->first();
        $verification_otp = rand(1000, 9999);
        $kitchen->verification_otp = $verification_otp;
        $kitchen->save();
        // SmsHelper::send($customer->phone,'GrozApp Verification OTP is '. $verification_otp);
        return response()->json(['message' => 'OTP sent successfully. Please verify OTP', 'verification_otp' => $verification_otp]);
    }

    /**
     * Insert Token .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function insertToken(Request $request)
    {
        //$customer = Customer::find($request->customer_id);
        $kitchen = Kitchen::whereId($request->user('api-kitchen')->id)->first();
        PushNotification::where('token', $request->token)->delete();
        $PushNotification = PushNotification::create([
            'user_id' => $kitchen->id,
            'user_type' => 2,
            'token' => $request->token,
        ]);
        if ($PushNotification) {
            return response()->json(['message' => 'Success']);
        } else {
            return response()->json(['error' => 'Failed']);
        }

    }

    /**
     * Change Customer Mobile Number .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function changeNumber(Request $request)
    {

        //$customer = Customer::find($request->customer_id);
        $phone = Kitchen::where('phone', $request->phone)->get();
        $kitchen = Kitchen::whereId($request->user('api-kitchen')->id)->first();
        if (count($phone) > 0) {
            return response()->json(['message' => 'Phone already in use', 'status' => 'failed']);
        } else {
            $verification_otp = rand(100000, 999999);
            $kitchen->phone = $request->phone;
            $kitchen->verification_otp = $verification_otp;
            $kitchen->save();
            // SmsHelper::send($customer->phone,'GrozApp Verification OTP is '. $verification_otp);
            return response()->json(['message' => 'Changed Number and OTP sent successfully. Please verify OTP', 'verification_otp' => $verification_otp, 'status' => 'success']);
        }
    }

}
