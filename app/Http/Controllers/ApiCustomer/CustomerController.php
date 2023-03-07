<?php
namespace App\Http\Controllers\ApiCustomer;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Model\Faq;
use App\Model\Information;
use App\Model\KitchenFavorite;
use Illuminate\Http\Request;

//use Cart;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api-customer');
    }

    /**
     * Update the Profile .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $customer = Customer::whereId($request->user()->id)->first();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|max:12|unique:customers,phone,' . $customer->id,
        ]);

        if ($customer->phone != $request->phone) {
            $verification_otp = rand(1000, 9999);
            // SmsHelper::send($request->phone,'Thechef Verification OTP is '. $verification_otp);
            if ($customer->update([
                'verification_otp' => $verification_otp,
            ])) {
                return response()->json(['message' => 'Please verify your OTP - ' . $verification_otp, 'status' => 2, 'otp' => $verification_otp], 201);
            }

        } else {
            if ($customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ])) {
                return response()->json(['message' => 'Profile Updated Successfully', 'customer' => $customer, 'status' => 1], 201);
            } else {
                return response()->json(['message' => 'Something went wrong!!! Try again', 'status' => 0], 422);
            }
        }
    }

    public function submitUpdateProfile(Request $request)
    {
        file_put_contents('updatephonenumber.txt', "");
        error_log(json_encode($request->all()), 3, 'updatephonenumber.txt');
        $customer = Customer::whereId($request->user('api-customer')->id)->first();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|max:12|unique:customers,phone,' . $customer->id,
            'verification_otp' => 'required|integer',
        ]);

        if ($customer->verification_otp != $request->verification_otp) {
            return response()->json(['message' => 'Invalid OTP', 'status' => 2], 422);
        }

        //Session::forget('verification_otp');

        // dd($customer);

        if ($customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'verification_otp' => 0,
        ])) {
            return response()->json(['message' => 'Profile Updated Successfully', 'customer' => $customer, 'status' => 1]);
        } else {
            return response()->json(['message' => 'Something went wrong!!! Try again', 'status' => 0], 422);
        }

    }

    /**
     * Get Customer Address .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAddress(Request $request)
    {

        $customer_id = $request->user('api-customer')->id;
        //$customer_id=1;

        $addresses = CustomerAddress::with('state', 'country')->where('customer_id', $customer_id)->get();
        //print_r($addresses);exit;
        $addressDetails = [];
        foreach ($addresses as $address) {
            $addressDetails[] = [
                'id' => $address->id,
                'name' => $address->name,
                'postcode' => $address->postcode,
                'phone' => $address->phone,
                'city' => $address->city,
                'locality' => $address->locality,
                'address_line1' => $address->address_line_1,
                'address_line2' => $address->address_line_2,
                'landmark' => $address->landmark,
                'street_name' => $address->street_name,
                'address_type' => $address->address_type,
                'latitude' => $address->latitude,
                'longitude' => $address->longitude,
            ];
        }
        return response()->json(['address' => $addressDetails]);
    }

    /**
     * Change Customer Address .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function editAddress(Request $request)
    {
        /* $customer_id = $request->user('api-customer')->id;*/
        $customer_id = 1;
        $CustomerAddress = CustomerAddress::where('customer_id', $customer_id)->where('id', $request->address_id)->first();
        return response()->json(['address' => $CustomerAddress]);

    }
    public function deleteAddress(Request $request)
    {
        $customer_id = $request->user('api-customer')->id;
        //$customer_id=1;
        CustomerAddress::where('id', $request->address_id)->delete();
        $addresses = CustomerAddress::with('state', 'country')->where('customer_id', $customer_id)->get();
        $addressDetails = [];
        foreach ($addresses as $address) {
            $addressDetails[] = [
                'id' => $address->id,
                'name' => $address->name,
                'postcode' => $address->postcode,
                'phone' => $address->phone,
                'city' => $address->city,
                'locality' => $address->locality,
                'address_line1' => $address->address_line_1,
                'address_line2' => $address->address_line_2,
                'landmark' => $address->landmark,
                'street_name' => $address->street_name,
                'address_type' => $address->address_type,
                // 'state'=>$address->state->name,
                // 'country'=>$address->country->name
            ];
        }
        return response()->json(['address' => $addressDetails]);

    }
    public function addAddress(Request $request)
    {
        //print_r(($request->all()));exit;
        $customer_id = $request->user('api-customer')->id;
        //$customer_id=1;
        $customerAddress = CustomerAddress::where('customer_id', $customer_id)->get();

        $edit_id = $request->edit_id;
        if (!empty($edit_id)) {
            $CustomerAddress = CustomerAddress::where('customer_id', $customer_id)->where('id', $edit_id)->first();
            $CustomerAddress->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city' => $request->city,
                'locality' => $request->locality,
                'address_line_1' => $request->address_1,
                'address_line_2' => $request->address_2,
                'landmark' => $request->landmark,
                'street_name' => $request->street_name,
                'additional_phone' => $request->additional_phone,
                //'postcode'=>$request->postcode,
                //'area'=>$request->area,
                'type' => $request->type,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'address_type' => $request->address_type,
            ]);
            $message = "Address updated successfully";
        } else {
            $addressComponent = $request->addressComponent;
            $country = '';
            if ($request->countryCode) {
                $country = Country::where('iso_code_2', $request->countryCode)->first();
            }
            //   if($request->stateName){
            //       $state=State::where('name',stateName)->first();
            //     }
            CustomerAddress::create([
                'customer_id' => $customer_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'country_id' => $country ? $country->id : '',
                'state_id' => $request->state_id,
                'city' => $request->city,
                'locality' => $request->locality,
                'address_line_1' => $request->address_1,
                'address_line_2' => $request->address_2,
                'landmark' => $request->landmark,
                'street_name' => $request->street_name,
                'additional_phone' => $request->additional_phone,
                //'postcode'=>$request->postcode,
                //'area'=>$request->area,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'address_type' => $request->address_type,
                'type' => $request->type,
                'default_status' => $customerAddress->count() == 0 ? 1 : 0,

            ]);
            $message = "Address added successfully.";
        }
        return response()->json(['message' => $message]);
    }

    /**
     * Set Default Customer Address .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setAsDefault(Request $request)
    {
        // $customer_id = $request->user('api-customer')->id;
        $customer_id = 1;
        $CustomerAddress = CustomerAddress::where('customer_id', $customer_id)->where('id', $request->address_id)->first();
        $CustomerAddress->default = 1;
        $CustomerAddress->save();
        CustomerAddress::where('customer_id', '=', $customer_id)->where('id', '<>', $request->address_id)->update(['default' => 0]);
        return response()->json(CustomerAddress::where('customer_id', $customer_id)->get());

    }
    /**
     * Get Default Customer Address .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDefaultAddress(Request $request)
    {
        $customer_id = $request->user('api-customer')->id;

        $CustomerAddress = CustomerAddress::where('customer_id', $customer_id)->first();

        return response()->json(['address' => $CustomerAddress]);

    }
    /**
     * Get Address By Id .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAddressById(Request $request)
    {
        $customer_id = $request->user('api-customer')->id;

        $CustomerAddress = CustomerAddress::where('customer_id', $customer_id)->where('id', $request->addressId)->first();

        return response()->json(['address' => $CustomerAddress]);

    }
    /**
     * Get informations .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInformation(Request $request)
    {
        //print_r($request->all());exit();

        $information = Information::where('id', $request->slug)->first();
        //  return response()->json($information);
        return response()->json(['information' => ['title' => $information->title,
            'description' => $information->description]]);

    }
    /**
     * Get faq .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFaq(Request $request)
    {

        $faqs = Faq::where('status', 1)->where('type', 0)->orderBy('sort_order')->get();
        $allfaq = [];

        foreach ($faqs as $faq) {
            $allfaq[] = [
                'id' => $faq->id,
                'title' => $faq->question,
                'content' => $faq->answer];

        }

        return response()->json(['faq' => $allfaq]);

    }
    /**
     * Set kitchen favorite .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function favoriteKitchen(Request $request)
    {

        $favorite = KitchenFavorite::where('kitchen_id', $request->kitchen_id)->where('customer_id', $request->user('api-customer')->id)->first();

        if (!empty($favorite)) {
            $favorite->delete();

            return response()->json(['message' => 'Favourite Removed Successfully', 'status' => 0]);
        } else {

            KitchenFavorite::create(['kitchen_id' => $request->kitchen_id, 'customer_id' => $request->user('api-customer')->id]);
            return response()->json(['message' => 'Favourite Added Successfully', 'status' => 1]);
        }

    }

    /**
     * Get  favorite kitchen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFavoriteKitchen(Request $request)
    {
        $favoriteKitchen = [];
        $favorites = KitchenFavorite::with('kitchen.kitchenDetails')->where('customer_id', $request->user('api-customer')->id)->get();

        if (!empty($favorites)) {

            foreach ($favorites as $favorite) {
                $favoriteKitchen[] = [

                    'id' => $favorite->kitchen->id,
                    'name' => $favorite->kitchen->name,
                    'kitchen_about' => $favorite->kitchen->kitchenDetails->about,
                    'kitchen_specialities' => $favorite->kitchen->kitchenDetails->specialities,
                    'kitchen_description' => $favorite->kitchen->kitchenDetails->description,
                    'location' => $favorite->kitchen->street_name . ',' . $favorite->kitchen->city,
                    'image' => !empty($favorite->kitchen->getMedia('kitchen')->first()) ? $favorite->kitchen->getMedia('kitchen')->first()->getUrl() : '',

                ];

            }
            return response()->json(['kitchens' => $favoriteKitchen]);
        } else {

            return response()->json(['kitchens' => $favoriteKitchen]);
        }

    }
    /**
     * Remove  favorite kitchen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeFavorite(Request $request)
    {
        $favoriteKitchen = [];

        $delFavorite = KitchenFavorite::where('kitchen_id', $request->kitchen_id)->where('customer_id', $request->user('api-customer')->id)->first();
        $delFavorite->delete();

        $favorites = KitchenFavorite::with('kitchen.kitchenDetails')->where('customer_id', $request->user('api-customer')->id)->get();

        if (!empty($favorites)) {

            foreach ($favorites as $favorite) {
                $favoriteKitchen[] = [

                    'id' => $favorite->kitchen->id,
                    'name' => $favorite->kitchen->name,
                    'kitchen_about' => $favorite->kitchen->kitchenDetails->first()->about,
                    'kitchen_specialities' => $favorite->kitchen->kitchenDetails->first()->specialities,
                    'kitchen_description' => $favorite->kitchen->kitchenDetails->first()->description,
                    'location' => $favorite->kitchen->street_name . ',' . $favorite->kitchen->city,
                    'image' => !empty($favorite->kitchen->getMedia('kitchen')->first()) ? $favorite->kitchen->getMedia('kitchen')->first()->getUrl() : '',

                ];

            }
            return response()->json(['kitchens' => $favoriteKitchen]);
        } else {

            return response()->json(['kitchens' => $favoriteKitchen]);
        }

    }

}
