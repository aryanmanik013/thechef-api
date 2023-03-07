<?php

namespace App\Http\Controllers\ApiCustomer\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Otp;
use App\Model\Customer;
use App\Model\PushNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        $customer = Customer::wherePhone($request->phone)->first();
        if (!empty($customer)) {
            $credentials = ['phone' => $request->phone, 'password' => $request->phone, 'phone_prefix' => $request->prefix];
            if (!Auth::guard('customer')->attempt($credentials)) {
                return response()->json(['message' => 'Invalid Login Credentials'], 401);
            }
            Auth::guard('customer')->attempt($credentials);
            $user = $request->user('customer');
            $tokenResult = $user->createToken('CHFCustomer');
            $token = $tokenResult->token;
            $token->save();
            $user->verification_otp = $verification_otp = rand(1000, 9999);
            $user->save();
            SmsHelper::send($customer->phone, 'Your verification code for The Chef login is ' . $user->verification_otp . '.');
            if ($user->status == 0) {
                return response()->json(['message' => 'Your account has been blocked. Please contact Admin'], 401);
            } else {
                return response()->json([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                    'verification_otp' => $verification_otp,
                    'user' => $user,
                    'type' => 'Login',
                ]);
            }
        } else {
            $verification_otp = rand(1000, 9999);
            $user = new Customer([
                'name' => $request->phone,
                'email' => $request->phone . '@thechef.com',
                'phone' => $request->phone,
                'phone_prefix' => $request->prefix,
                'password' => bcrypt($request->phone),
                'verification_otp' => $verification_otp,
            ]);
            $user->save();

            // Mail::to($user->email,$user->name)->send(new Otp($user));

            $credentials = ['phone' => $request->phone, 'password' => $request->phone, 'phone_prefix' => $request->prefix];
            if (Auth::attempt($credentials)) {
                $user = Auth::guard('customer')->user();
            }

            $tokenResult = $user->createToken('CHFCustomer');
            $token = $tokenResult->token;
            $token->save();
            SmsHelper::send($user->phone, 'Thank you for registering with The Chef. Please enter OTP ' . $user->verification_otp . ' to verify your account.');
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'user' => $user,
                'verification_otp' => $verification_otp,
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'message' => 'User has been successfully created!',
            ], 201);

            //Mail::to($user->email,'The Chef')->send(new Register($user));

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
        return response()->json($request->user());
    }

    /**
     * Verify OTP .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function otpVerify(Request $request)
    {
        $customer = Customer::whereId($request->user('api-customer')->id)->first();
        if ($customer->verification_otp == $request->otp) {
            if (isset($request->type) && $request->type == 'forgotPassword') {
                $customer->verification_status = 0;
            } else {
                $customer->verification_status = 1;
            }
            $customer->verification_otp = 0;
            $customer->save();

            return response()->json(['message' => 'OTP Verification Success', 'status' => 1]);
        } else {
            return response()->json(['error' => 'OTP you have entered is Invalid.', 'status' => 0], 422);
        }
        return;
    }

    /**
     * Set Profile Name .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function setProfileName(Request $request)
    {
        $customer = Customer::whereId($request->user('api-customer')->id)->first();
        $customer->name = $request->name;
        $customer->save();

        if ($customer->name == $request->name) {
            return response()->json(['message' => 'Profile name updated successfully', 'user' => $customer]);
        } else {
            return response()->json(['error' => 'Something Went Wrong!!.'], 422);
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
        $customer = Customer::whereId($request->user('api-customer')->id)->first();
        $verification_otp = rand(1000, 9999);
        $customer->verification_otp = $verification_otp;
        $customer->save();
        // SmsHelper::send($customer->phone,'GrozApp Verification OTP is '. $verification_otp);
        // Mail::to($user->email,$user->name)->send(new Otp($user));

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
        $customer = Customer::whereId($request->user('api-customer')->id)->first();
        PushNotification::where('token', $request->token)->delete();
        $PushNotification = PushNotification::create([
            'user_id' => $customer->id,
            'user_type' => 1,
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
        $phone = Customer::where('phone', $request->phone)->get();
        $customer = Customer::whereId($request->user('api-customer')->id)->first();
        if (count($phone) > 0) {
            return response()->json(['message' => 'Phone already in use', 'status' => 'failed']);
        } else {
            $verification_otp = rand(100000, 999999);
            $customer->phone = $request->phone;
            $customer->verification_otp = $verification_otp;
            $customer->save();
            // SmsHelper::send($customer->phone,'GrozApp Verification OTP is '. $verification_otp);
            return response()->json(['message' => 'Changed Number and OTP sent successfully. Please verify OTP', 'verification_otp' => $verification_otp, 'status' => 'success']);
        }
    }
}
