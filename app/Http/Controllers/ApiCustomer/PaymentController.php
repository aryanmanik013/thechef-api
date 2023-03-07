<?php

namespace App\Http\Controllers\ApiCustomer;

use App\Http\Controllers\Controller;
use App\Mail\Kitchen\OrderCreatedKitchen;
use App\Mail\OrderCreated;
use App\Model\KitchenFood;
use App\Model\Notification;
use App\Model\Order;
use App\Model\OrderPayment;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PushNotificationHelper;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($orderId)
    {
        // $customer_id = $request->user('api-customer')->id;

        $order = Order::whereId($orderId)->orderBy('id', 'desc')->first();
        if (!empty($order)) {
            $kitchenName = preg_replace('/[^A-Za-z0-9\-]/', '', $order->kitchen_name);
            $paymentMode = env("CASHFREE_MODE", "TEST");
            $secretKey = env("CASHFREE_SECRET_KEY", "a487b594cf3cfcab6f6b502d621057aac5f40d81");
            $payment = [
                'appId' => env("CASHFREE_APP_ID", "3023839593dcf067adc12efa583203"),
                'orderId' => $order->id,
                'orderAmount' => round($order->order_total),
                'orderCurrency' => 'INR',
                'orderNote' => 'Order ID: ' . $order->invoice_prefix . $order->id . ' : Kitchen: ' . $kitchenName,
                'customerName' => $order->name,
                'customerPhone' => $order->phone,
                'customerEmail' => $order->email,
                'returnUrl' => 'https://thechef.tnmos.com/public/api-customer/paymentStatus',
                'notifyUrl' => 'https://thechef.tnmos.com/public/api-customer/paymentStatus/' . $order->id,
            ];

            ksort($payment);
            $signatureData = "";
            foreach ($payment as $key => $value) {
                $signatureData .= $key . $value;
            }
            $signature = hash_hmac('sha256', $signatureData, $secretKey, true);
            $signature = base64_encode($signature);

            if ($paymentMode == "TEST") {
                $url = "https://test.cashfree.com/billpay/checkout/post/submit";
            } else {
                $url = "https://www.cashfree.com/checkout/post/submit";
            }
            //  file_put_contents('paymentIndex.txt', "");
            error_log(json_encode([
                'paymentData' => $payment,
                'signature' => $signature,
                'paymentUrl' => $url,
            ]), 3, 'paymentIndex.txt');
            return view('payment.index')->with([
                'paymentData' => $payment,
                'signature' => $signature,
                'paymentUrl' => $url,
            ]);
        } else {
            return response()->json(['message' => 'something went wrong'], 422);
        }
    }

    public function status(Request $request)
    {
        // dd($request->all());

        $secretkey = env("CASHFREE_SECRET_KEY", "null");
        $orderId = $request->orderId;
        $orderAmount = $request->orderAmount;
        $referenceId = $request->referenceId;
        $txStatus = $request->txStatus;
        $paymentMode = $request->paymentMode;
        $txMsg = $request->txMsg;
        $txTime = $request->txTime;
        $signature = $request->signature;
        $data = $orderId . $orderAmount . $referenceId . $txStatus . $paymentMode . $txMsg . $txTime;
        $hash_hmac = hash_hmac('sha256', $data, $secretkey, true);
        $computedSignature = base64_encode($hash_hmac);
        if ($signature == $computedSignature) {
            OrderPayment::create([
                'order_id' => $orderId,
                'reference_id' => $referenceId,
                'payment_mode' => $paymentMode,
                'currency' => 'INR',
                'amount' => $orderAmount,
                'payment_status' => $txStatus,
                'payment_signature' => $signature,
                'payment_time' => $txTime,
                'status' => 1,
            ]);
            $order = Order::whereId($orderId)->first();
            $order->update(['order_status_id' => 1]);
            return redirect('api-customer/paymentSuccess/' . $request->orderId);
        } else {
            return redirect('api-customer/paymentFailure/' . $request->orderId);
        }
    }

    public function success($orderId)
    {
        $order = Order::with('food.food', 'kitchen')->whereId($orderId)->first();
        Cart::restore($order->customer_id);
        /*foreach($order->food as $food)
        {
        KitchenFood::find($food->kitchen_food_id)->decrement('quantity',$food->quantity);
        }*/
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
        if ($order->delivery_partner_id) {
            $title = 'Order Placed';
            $body = 'Kitchen has received the order' . $order->invoice_prefix . $order->id . '. Please wait for kitchen confirmation.';
            $status = PushNotificationHelper::notify($title, $body, [], [$order->delivery_partner_id], 'Home', 3);
        }

        /*$PushNotification = Notification::create([
        'title'=>$title,
        'user_id'=>$order->kitchen_id,
        'user_type'=>3,
        'parameter'=>$order->id,
        'route'=>'Home',
        'status'=>1,
        'message'=>$body
        ]);*/

        Cart::destroy();
        // SmsHelper::send($order->phone,'Thank you for using the chefapp. Please enter OTP '. $user->verification_otp .' to login');
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $order->name);
        Mail::to($order->email, $name)->send(new OrderCreated($order));
        $kitchenName = preg_replace('/[^A-Za-z0-9\-]/', '', $order->kitchen->name);
        Mail::to($order->kitchen->email, $kitchenName)->send(new OrderCreatedKitchen($order));

        return view('payment.success');
    }

    public function failure($orderId)
    {
        $order = Order::with('food.food')->whereId($orderId)->first();
        $order->update(['order_status_id' => 10]);
        foreach ($order->food as $food) {
            KitchenFood::find($food->kitchen_food_id)->increment('quantity', $food->quantity);
        }
        return view('payment.failure');
    }
}
