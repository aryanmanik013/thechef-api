<?php

namespace App\Http\Controllers\ApiDeliveryPartner\Auth;

use App\Http\Controllers\Controller;
use App\Model\DeliveryPartner;
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
        //file_put_contents('login.txt', "");
        //error_log(json_encode($request->all()), 3, 'login.txt');
        $deliveryPartner = DeliveryPartner::wherePhone($request->phone)->where('phone_prefix', $request->prefix)->first();
        if (!empty($deliveryPartner)) {

            $credentials = ['phone' => $request->phone, 'password' => $request->phone, 'phone_prefix' => $request->prefix];
            if (!Auth::guard('deliveryPartner')->attempt($credentials)) {
                return response()->json(['message' => 'Invalid Login Credentials'], 401);
            }
            $user = $request->user('deliveryPartner');
            $tokenResult = $user->createToken('CHFDeliveryPartner');
            $token = $tokenResult->token;
            $token->save();
            $user->verification_otp = $verification_otp = rand(1000, 9999);
            $user->save();

            if ($user->status == 0) {
                return response()->json(['message' => 'Your account has been blocked. Please contact Admin'], 401);
            } else {
                SmsHelper::send($user->phone, 'Your verification code for The Chef Delivery Partner login is ' . $user->verification_otp . '.');
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
            $user = new DeliveryPartner([
                'name' => $request->phone,
                'email' => $request->phone . '@thechef.com',
                'phone' => $request->phone,
                'phone_prefix' => $request->prefix,
                'password' => bcrypt($request->phone),
                'verification_otp' => $verification_otp,
            ]);
            $user->save();
            SmsHelper::send($user->phone, 'Thank you for registering as The Chef Delivery Partner. Please enter OTP ' . $user->verification_otp . ' to verify your account.');
            // Mail::to($user->email,'Groz App')->send(new Register($user));
            $credentials = ['phone' => $request->phone, 'password' => $request->phone, 'phone_prefix' => $request->prefix];
            if (Auth::attempt($credentials)) {
                $user = Auth::guard('deliveryPartner')->user();
            }

            $tokenResult = $user->createToken('CHFDeliveryPartner');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'user' => $user,
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
        $deliveryPartner = DeliveryPartner::whereId($request->user('api-deliveryPartner')->id)->first();
        if ($deliveryPartner->verification_otp == $request->otp) {
            if (isset($request->type) && $request->type == 'forgotPassword') {
                $deliveryPartner->verification_status = 0;
            } else {
                $deliveryPartner->verification_status = 1;
            }
            $deliveryPartner->verification_otp = 0;
            $deliveryPartner->save();

            return response()->json(['message' => 'OTP Verification Success', 'status' => 1]);
        } else {
            return response()->json(['error' => 'OTP you have entrered is Invalid.', 'status' => 0]);
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
        $deliveryPartner = DeliveryPartner::whereId($request->user('api-deliveryPartner')->id)->first();
        $verification_otp = rand(1000, 9999);
        $deliveryPartner->verification_otp = $verification_otp;
        $deliveryPartner->save();
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
        $deliveryPartner = DeliveryPartner::whereId($request->user('api-deliveryPartner')->id)->first();
        PushNotification::where('token', $request->token)->delete();
        $PushNotification = PushNotification::create([
            'user_id' => $deliveryPartner->id,
            'user_type' => 3,
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
        $phone = DeliveryPartner::where('phone', $request->phone)->get();
        $deliveryPartner = DeliveryPartner::whereId($request->user('api-deliveryPartner')->id)->first();
        if (count($phone) > 0) {
            return response()->json(['message' => 'Phone already in use', 'status' => 'failed']);
        } else {
            $verification_otp = rand(100000, 999999);
            $deliveryPartner->phone = $request->phone;
            $deliveryPartner->verification_otp = $verification_otp;
            $deliveryPartner->save();
            // SmsHelper::send($customer->phone,'GrozApp Verification OTP is '. $verification_otp);
            return response()->json(['message' => 'Changed Number and OTP sent successfully. Please verify OTP', 'verification_otp' => $verification_otp, 'status' => 'success']);
        }
    }

}
