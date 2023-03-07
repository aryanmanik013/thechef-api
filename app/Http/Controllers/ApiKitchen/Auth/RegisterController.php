<?php

namespace App\Http\Controllers\ApiKitchen\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Register;
use App\Model\Kitchen;
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
        file_put_contents('register_kitchen.txt', "");
        error_log(json_encode($request->all()), 3, 'register_kitchen.txt');
        // $verification_otp = rand(100000,999999);

        // return response()->json($request->user('api-kitchen'));
        $kitchen = Kitchen::whereId($request->user('api-kitchen')->id)->first();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:kitchens,email,' . $kitchen->id,
            'phone' => 'required|max:12|unique:kitchens,phone,' . $kitchen->id,
        ]);

        $kitchen->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'street_name' => $request->street_name,
            'landmark' => $request->landmark,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            // 'verification_otp'=>$verification_otp
        ]);

        // $user->save();

        /*SmsHelper::send($request->phone,'GheeRice Verification OTP is '. $verification_otp);

        Mail::to($user->email,'The Chef App')->send(new Register($user));

        $credentials = request(['email', 'password']);

        if(Auth::attempt($credentials))
        $user = Auth::guard('kitchen')->user();

        $tokenResult = $user->createToken('TheChef');
        $token = $tokenResult->token;
        $token->save();*/

        return response()->json([
            /*'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',*/
            'kitchen' => $kitchen,
            // 'verification_otp' => $verification_otp,
            // 'expires_at' => Carbon::parse(
            //     $tokenResult->token->expires_at
            // )->toDateTimeString(),
            'message' => 'Kitchen profile has been submitted for verification!',
        ], 201);

    }
}
