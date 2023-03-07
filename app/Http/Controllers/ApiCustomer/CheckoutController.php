<?php

namespace App\Http\Controllers\ApiCustomer;

use App\Http\Controllers\Controller;
use App\Model\AssignedDelivery;
use App\Model\Country;
use App\Model\Coupon;
use App\Model\CouponHistory;
use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Model\DeliveryCharge;
use App\Model\DeliveryPartner;
use App\Model\Kitchen;
use App\Model\KitchenFood;
use App\Model\Notification;
use App\Model\Order;
use App\Model\OrderDeliveryHistory;
use App\Model\Settings;
use App\Model\Store;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PushNotificationHelper;

/*use App\Mail\OrderCreated;
 */
class CheckoutController extends Controller
{
    protected $customerId;

    public function index(Request $request)
    {

        // Cart::restore($request->user('api-customer')->id);
        // $carts = Cart::content();
        // Cart::store($request->user('api-customer')->id);

        // if(!$carts->count()){
        //     return response()->json(['message' => 'Cart is empty'],422);
        // }

        // $store_id=$carts->first()->options->store_id;

        // $customer_adress=CustomerAddress::where('customer_id',$request->user('api-customer')->id)->where('default',1)->first();

        // //dd($membership_cards);
        // $cartCount = count(Cart::content());
        // $cart_total=Cart::total();

        // return response()->json(['cartCount' => $cartCount, 'cart' => $carts,'cartTotal'=>$cart_total,$membership_cards,'customer_address'=>$customer_adress]);

    }

    public function store(Request $request)
    {

        file_put_contents('store.txt', "");
        error_log(json_encode($request->all()), 3, 'store.txt');

        $delivery_charge = $request->deliveryCharge;
        $couponCheck = 0;
        $coupon = [];

        $order = new Order();
        $customer = Customer::whereId($request->user('api-customer')->id)->first();

        $invoice_prefix = Settings::where('title', 'invoice_prefix')->first();
        Cart::restore($customer->id);
        $carts = Cart::content();
        Cart::store($customer->id);

        if (!$carts->count()) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }
        $kitchen = kitchen::with('country', 'state')->where('id', $request->kitchen_id)->first();
        $billing_address = '';
        $shipping_address = '';
        if (!empty($request->shipping_address)) {
            $shipping_address = CustomerAddress::with('country', 'state')->whereId($request->shipping_address)->first();
            $billing_address = $shipping_address;
        }
        foreach ($carts as $cart) {
            $kitchenFood = KitchenFood::whereId($cart->id)->first();
            if ($kitchenFood->quantity < $cart->qty) {
                return response()->json(['message' => 'Cart quantity is not available'], 422);
            }
        }

        foreach ($carts as $cart) {
            $kitchenFood = KitchenFood::where('id', $cart->id)->first();
            $quantity = $kitchenFood->quantity - $cart->qty;
            $kitchenFood->update(['quantity' => $quantity]);
        }

        $order->customer_id = $customer->id;

        $order->invoice_prefix = $invoice_prefix->value;

        $order->name = $customer->name;
        $order->email = $customer->email;
        $order->phone = $customer->phone;
        $order->kitchen_id = $kitchen->id;
        $order->kitchen_name = $kitchen->name;

        $order->payment_name = $billing_address ? $billing_address['name'] : $customer->name;
        $order->payment_phone = $billing_address ? $billing_address['phone'] : $customer->phone;
        $order->payment_address_1 = $shipping_address ? $shipping_address->address_line_1 : $kitchen->address_line_1;
        $order->payment_address_2 = $shipping_address ? $shipping_address->address_line_2 : $kitchen->address_line_2;

        $order->payment_city = $shipping_address ? str_replace(",", ",", $shipping_address->city) : $kitchen->city;
        $order->payment_postcode = $shipping_address ? $shipping_address->pincode : $kitchen->postcode;
        $order->payment_landmark = $shipping_address ? $shipping_address->landmark : $kitchen->landmark;

        $order->payment_additional_phone = $shipping_address ? $shipping_address->phone : $customer->phone;
        $order->payment_country = $kitchen->country ? $kitchen->country->name : 'IND';
        $order->payment_country_id = $kitchen->country_id;
        $order->payment_state = $kitchen->state ? $kitchen->state->name : '';
        $order->payment_state_id = $kitchen->state_id;
        $order->payment_method = $request->payment_method;
        $order->payment_code = 0;

        $order->shipping_name = $shipping_address ? $shipping_address->name : $customer->name;
        $order->shipping_phone = $shipping_address ? $shipping_address->phone : $customer->phone;
        $order->shipping_address_1 = $shipping_address ? $shipping_address->address_line_1 : $kitchen->address_line_1;
        $order->shipping_address_2 = $shipping_address ? $shipping_address->address_line_2 : $kitchen->address_line_2;
        $order->shipping_city = $shipping_address ? str_replace(",", ",", $shipping_address->city) : $kitchen->city;
        $order->shipping_postcode = $shipping_address ? $shipping_address->pincode : $kitchen->postcode;
        $order->shipping_landmark = $shipping_address ? $shipping_address->landmark : $kitchen->landmark;
        $order->shipping_latitude = $shipping_address ? $shipping_address->latitude : $kitchen->latitude;
        $order->shipping_longitude = $shipping_address ? $shipping_address->longitude : $kitchen->longitude;

        $order->shipping_additional_phone = $shipping_address ? $shipping_address->phone : $customer->phone;
        $order->shipping_country = $shipping_address ? $shipping_address->country ? $shipping_address->country->iso_code_3 : 'IND' : 'IND';
        $order->shipping_country_id = $shipping_address ? $shipping_address->country_id ? $kitchen->country_id : $kitchen->country_id : $kitchen->country_id;
        $order->shipping_state = $shipping_address ? $shipping_address->state ? $shipping_address->state->name : $kitchen->state->name : $kitchen->state->name;
        $order->shipping_state_id = $shipping_address ? $shipping_address->state_id ? $shipping_address->state_id : $kitchen->state_id : $kitchen->state_id;
        $order->shipping_method = 0;
        $order->shipping_code = 0;
        $delivery_charge = 0;
        if (!empty($shipping_address)) {
            $latitude = $shipping_address->latitude;
            $longitude = $shipping_address->longitude;
            $kitchenId = $kitchen->id;
            $deliveryKitchen = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $kitchenId])
                ->whereRaw("id='$kitchenId'")
                ->first();

            $delivery = DeliveryCharge::where('state_id', $deliveryKitchen->state_id)->where('status', 1)->first();

            if (!empty($delivery->minimum_distance)) {
                if ($delivery->minimum_distance >= $deliveryKitchen->distance) {
                    $delivery_charge = $delivery->minimum_charge;
                } else {
                    $extraDistance = $deliveryKitchen->distance - $delivery->minimum_distance;
                    $delivery_charge = $delivery_charge + ($extraDistance * $delivery->charge);
                }
            } elseif (!empty($delivery->charge)) {
                $delivery_charge = $delivery_charge + ($deliveryKitchen->distance * $delivery->charge);
            }
        }
        //$order->currency_code='INR';
        $order->comment = '';
        if ($request->deliveryType == 'delivery') {
            $order->delivery_type = 1;
        } else if ($request->deliveryType == 'partner') {

            $order->delivery_type = 2;
            $order->delivery_charge = $delivery_charge;
            $order->delivery_partner_id = $request->deliveryPartnerId;
            $order->delivery_request_id = $request->deliveryRequestId ? $request->deliveryRequestId : '';
            $order->delivery_status_id = 1;

            // $order->    deliveryRequestId;
        } else {
            $order->delivery_type = 0;

            //$order->delivery_charge=$delivery_charge;
        }

        $order->total = Cart::total();
        //print_r($order);

        $coupon = [];
        if ($request->coupon_code) {
            $applyCoupon = $this->applyCoupon($request);
            if (!empty($applyCoupon->original['success'])) {
                $coupon = $applyCoupon->original['success'];
            } else {
                return response()->json([
                    'error' => ['message' => $applyCoupon->original['error']['message']],
                ]);
            }
        }

        if ($coupon) {
            $order->coupon_discount = $coupon['discount_total'];
            if ($delivery_charge && $request->deliveryType == 'partner') {
                $order->order_total = Cart::total() - $coupon['discount_total'] + $delivery_charge;
            } else {
                $order->order_total = Cart::total() - $coupon['discount_total'];
            }

        } else {
            if ($delivery_charge && $request->deliveryType == 'partner') {
                $order->order_total = str_replace(',', '', Cart::total()) + $delivery_charge;
            } else {
                $order->order_total = str_replace(',', '', Cart::total());
            }

        }
        $order->save();
        //dd($order);

        if ($coupon) {
            $order->coupon()->create([
                'coupon_id' => $coupon['coupon_id'],
                'customer_id' => $customer->id,
                'amount' => $coupon['discount_total'],
            ]);
        }

        $foods = [];
        foreach ($carts as $cart) {
            $foods[] = [
                'order_id' => $order->id,
                'kitchen_food_id' => $cart->id,
                'name' => $cart->name,
                'quantity' => $cart->qty,
                'price' => $cart->price,
                'total' => $cart->total,

            ];
        }
        $orderHistory[] = [
            'order_status_id' => 1,
            'notify' => 0,
            'comment' => 'Order Created',
        ];
        $cartTotal = $cart->total;

        $order_total[] = [
            'code' => 'sub_total',
            'title' => 'Sub-Total',
            'value' => $cartTotal,
        ];

        if (!empty($coupon)) {
            $order_total[] = [
                'code' => 'coupon',
                'title' => 'Coupon Discount',
                'value' => $coupon['discount_total'],
            ];
            $cartTotal = $cart->total - $coupon['discount_total'];
        }

        if ($delivery_charge && $request->deliveryType == 'partner') {
            $order_total[] = [
                'code' => 'delivery_charge',
                'title' => 'Delivery Charge',
                'value' => $delivery_charge,
            ];
            $cartTotal = $cartTotal + $delivery_charge;
        }

        $order_total[] = [
            'code' => 'total',
            'title' => 'Grand Total',
            'value' => $cartTotal,
        ];
        $order->food()->createMany($foods);
        $order->histories()->createMany($orderHistory);
        $order->totals()->createMany($order_total);

        if (!empty($request->deliveryRequestId)) {

            $delivery = AssignedDelivery::where('id', $request->deliveryRequestId)->where('active_status', 1)->where('accept_status', 1)->first();

            if (!empty($delivery)) {
                $delivery->update(['order_id' => $order->id]);
            }
            OrderDeliveryHistory::create(['order_id' => $order->id, 'delivery_status_id' => 1, 'comment' => 'Order accepted by delivery partner']);

        }

        if ($request->payment_method == 'COD') {

            $order->update(['order_status_id' => 1]);

            Cart::restore($request->user('api-customer')->id);
            Cart::destroy();
            $title = 'New Order ';
            $body = 'New Order ' . $order->invoice_prefix . $order->id . ' has been Placed';

            $status = PushNotificationHelper::notify($title, $body, ['orderId' => $order->id], [$order->kitchen_id], 'KitchenOrderDetail', 2);

            $PushNotification = Notification::create([
                'title' => $title,
                'user_id' => $order->kitchen_id,
                'user_type' => 2,
                'parameter' => $order->id,
                'route' => 'KitchenOrderDetail',
                'status' => 1,
                'message' => $body,
            ]);

            return response()->json(['orderId' => $order->id, 'message' => 'Your order has been successfully placed.'], 200);

        } elseif ($request->payment_method == 'Online') {
            return response()->json(['orderId' => $order->id, 'message' => 'Your order has been successfully placed.'], 200);
        } else {
            return response()->json(['message' => 'Something went wrong !!! Please try again'], 422);
        }
    }

    public function applyCoupon(Request $request)
    {

        // $cartItems = Cart::content();
        // Cart::store($request->user('api-customer')->id);
        file_put_contents('applyCoupon.txt', "");
        error_log(json_encode($request->all()), 3, 'applyCoupon.txt');
        if ($request->coupon_code) {
            $coupon = Coupon::with('categories')->where('code', $request->coupon_code)->where('start_date', '<=', date('Y-m-d'))->where('expiry_date', '>=', date('Y-m-d'))->first();
            $discount = [];
            //   error_log(json_encode($coupon->categories), 3, 'applyCouponCategories.txt');
            // $shipping_charge=100;
            $limit_available = false;
            if ($coupon) {
                if ($coupon->uses_total != 0) {
                    $uses_customer = CouponHistory::whereCustomerId(Auth::guard('api-customer')->user()->id)->count();
                    // $uses_customer = CouponHistory::whereCustomerId(1)->count();
                    if ($coupon->uses_customer) {
                        if ($coupon->uses_customer != 0 || $uses_customer < $coupon->uses_customer) {
                            $limit_available = true;
                        }
                    } else {
                        $limit_available = true;
                    }
                    if ($limit_available == true) {
                        Cart::restore($request->user('api-customer')->id);
                        //Cart::restore(1);

                        if ($coupon->minimum_amount && Cart::total() >= $coupon->minimum_amount) {
                            if ($coupon->type == 1) {
                                foreach (Cart::content() as $item) {
                                    // if($coupon->categories->whereIn('food_category_id',$item->model->categories->pluck('food_category_id')->toArray())) {
                                    if (!empty(array_intersect($coupon->categories->pluck('food_category_id')->toArray(), $item->model->categories->pluck('food_category_id')->toArray()))) {
                                        if ($coupon->discount_type == 1) {
                                            $discount[] = (($item->total * $coupon->discount) / 100);
                                        } else {
                                            $discount[] = $item->total > $coupon->discount ? $coupon->discount : $item->total;
                                        }
                                    }
                                }
                            } else {
                                if ($coupon->discount_type == 1) {
                                    $discount[] = (Cart::total() * $coupon->discount) / 100;
                                } else {
                                    $discount[] = $coupon->discount;
                                }
                            }
                            Cart::store($request->user('api-customer')->id);
                            //Cart::store(1);
                            if (empty($discount)) {
                                return response()->json([
                                    'error' => ['message' => 'Item(s) are not eligible for coupon discount'],
                                ]);
                            } else {
                                $total_discount = array_sum($discount);
                                if ($coupon->discount_type == 1) {
                                    if (!empty($coupon->maximum_discount_amount)) {
                                        if ($coupon->maximum_discount_amount < $total_discount) {
                                            $total_discount = $coupon->maximum_discount_amount;
                                        }
                                    }
                                }
                                if (Cart::total() < $total_discount) {
                                    $total_discount = Cart::total();
                                }
                                return response()->json([
                                    'success' => ['message' => 'Coupon Applied. Your cart discount is Rs. ' . number_format($total_discount, 2), 'discount_total' => $total_discount, 'coupon_id' => $coupon->id, 'coupon_code' => $request->coupon_code,
                                        'cartTotal' => Cart::total(),
                                        'discount' => $coupon->discount],
                                ], 200);

                            }
                        } else {
                            Cart::store($request->user('api-customer')->id);
                            //Cart::store(1);
                            return response()->json([
                                'error' => ['message' => 'Minimum cart amount should be Rs. ' . number_format($coupon->minimum_amount, 0) . ' or more'],
                            ]);
                        }
                    } else {
                        return response()->json([
                            'error' => ['You have redeemed this coupon maximum times'],
                        ]);
                    }
                } else {
                    return response()->json([
                        'error' => ['message' => 'Exceeded Maximum Usage'],
                    ]);
                }
            } else {
                return response()->json([
                    'error' => ['message' => 'Invalid Coupon or Expired'],
                ]);
            }
        } else {
            return response()->json([
                'error' => ['message' => 'Enter your coupon code'],
            ]);
        }
    }

    public function coupon(Request $request)
    {

        $coupons = Coupon::where('status', 1)->where('start_date', '<=', date('Y-m-d'))->where('expiry_date', '>=', date('Y-m-d'))->get();
        $allCoupons = [];
        foreach ($coupons as $coupon) {

            $date = Carbon::parse($coupon->expiry_date);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            if ($coupon->discount_type == 1) {
                $description = number_format($coupon->discount, 0) . '% Off On Order Above ' . number_format($coupon->minimum_amount, 0) . ' Upto ' . number_format($coupon->maximum_discount_amount, 0);
            } else {
                $description = number_format($coupon->discount, 0) . ' Rs Off On Order Above ' . number_format($coupon->minimum_amount, 0);
            }

            $allCoupons[] = [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'description' => $description,
                'expiry' => $diff . ' days',
                'maximum_amount' => number_format($coupon->maximum_discount_amount, 2),
                'type' => $coupon->discount_type,
                'discount' => number_format($coupon->discount, 2),

            ];
        }

        //return response()->json(CustomerMembershipCard::where('customer_id',$customer_id)->get());
        return response()->json(['coupons' => $allCoupons]);

    }

    /**
     * Search available delivery partners.
     *

     * @return \Illuminate\Http\Response
     */
    public function searchDeliveryPartner(Request $request)
    {

        $kitchen = kitchen::with('country', 'state')->where('id', $request->kitchenId)->first();

        $address = CustomerAddress::with('country', 'state')->whereId($request->addressId)->first();

        Cart::restore($request->user('api-customer')->id);
        $carts = Cart::content();
        $cart_count = count(Cart::content());
        $cartDetails = [];
        $pickup_time = [];

        Cart::store($request->user('api-customer')->id);

        if ($cart_count) {
            foreach ($carts as $cart) {
                if (strtotime($cart->model->available_time) != false) {
                    $pickup_time[] = strtotime($cart->model->available_time);
                }

            }
        }

        $max_pickup_time = !empty($pickup_time) ? max($pickup_time) : '';

        $kitchen_latitude = $kitchen->latitude;
        $kitchen_longitude = $kitchen->longitude;
        $customer_longitude = $address->longitude;
        $customer_latitude = $address->latitude;

        $distance = 5;

        $time = Carbon::now()->subMinutes(1)->toDateTimeString();

        $delivery_partners = DeliveryPartner::selectRaw('*, ( 6371 * acos( cos( radians(' . $kitchen_latitude . ' ) ) * cos( radians( last_latitude ) ) * cos( radians( last_longitude ) - radians(' . $kitchen_longitude . ' ) ) + sin( radians( ' . $kitchen_latitude . ' ) ) * sin( radians( last_latitude ) ) ) ) AS distance_from_kitchen ,
       ( 6371 * acos( cos( radians(' . $customer_latitude . ' ) ) * cos( radians( last_latitude ) ) * cos( radians( last_longitude ) - radians(' . $customer_longitude . ' ) ) + sin( radians( ' . $customer_latitude . ' ) ) * sin( radians( last_latitude ) ) ) ) AS distance_from_customer', [$customer_latitude, $customer_longitude, $distance, $kitchen_latitude, $kitchen_longitude])

            ->havingRaw('distance_from_kitchen <= 5')
            ->havingRaw('distance_from_customer <= 5')
            ->whereRaw('availability_status =1')
        //->whereRaw('location_updated_at >='.'"'.$time.'"')

            ->whereRaw('status=1')
            ->whereRaw('verification_status=1')
            ->whereRaw('approval_status=1')
            ->orderBy('distance_from_customer')
            ->get();

        if (!empty($delivery_partners) && $delivery_partners->count() != 0) {

            $temp_id = 'CHEF_' . Str::random() . rand(1000, 5000);
            foreach ($delivery_partners as $delivery_partner) {

                AssignedDelivery::create([
                    'order_temp_id' => $temp_id,
                    'pickup_time' => !empty($max_pickup_time) ? date("Y-m-d h:i:s", $max_pickup_time) : '',
                    'delivery_partner_id' => $delivery_partner->id,
                    'address_id' => $address->id,
                    'kitchen_id' => $kitchen->id,
                    'accept_status' => 0,

                ]);

                $title = 'New Order ';
                $body = 'New Order Request';

                $status = PushNotificationHelper::notify($title, $body, '', [$delivery_partner->id], 'Home', 3);

                $PushNotification = Notification::create([
                    'title' => $title,
                    'user_id' => $delivery_partner->id,
                    'user_type' => 3,
                    'parameter' => '',
                    'route' => 'Home',
                    'status' => 1,
                    'message' => $body,
                ]);
            }

            return response()->json(['message' => 'Delivery partners found ', 'count' => $delivery_partners->count(), 'tempId' => $temp_id, 'status' => 1]);

        } else {
            return response()->json(['message' => 'No delivery partners found ', 'count' => 0, 'status' => 0]);

        }

    }

    /**
     *Get assigned delivery partner details.
     *

     * @return \Illuminate\Http\Response
     */
    public function getAcceptedDelivery(Request $request)
    {

        file_put_contents('getAcceptedDelivery.txt', "");
        error_log(json_encode($request->all()), 3, 'getAcceptedDelivery.txt');

        $temp_id = $request->deliveryRequestId;

        $delivery = AssignedDelivery::where('order_temp_id', $temp_id)->where('accept_status', 1)->first();

        if (!empty($delivery)) {
            $delivery_partner = DeliveryPartner::whereId($delivery->delivery_partner_id)->first();
            return response()->json([
                'status' => 1,
                'deliveryPartnerName' => $delivery_partner->name,
                'deliveryId' => $delivery->id,
                'orderTempId' => $delivery->order_temp_id,
                'deliveryPartnerId' => $delivery_partner->id,
                'AssignedDate' => $delivery->accept_date,
            ]);
        } else {
            return response()->json([
                'status' => 0,

            ]);

        }
    }

    /**
     *Cancel  assigned delivery .
     *

     * @return \Illuminate\Http\Response
     */
    public function cancelAcceptedDelivery(Request $request)
    {

        $temp_id = $request->deliveryRequestId;
        AssignedDelivery::where('order_temp_id', $temp_id)->where('active_status', 1)->update(['active_status' => 0]);

        return response()->json([
            'status' => 1,
            'message' => 'success',
        ]);

    }
}
