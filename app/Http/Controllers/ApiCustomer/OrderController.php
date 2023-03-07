<?php

namespace App\Http\Controllers\ApiCustomer;

use App\Http\Controllers\Controller;
use App\Mail\CancelOrder;
use App\Mail\Kitchen\CancelOrderKitchen;
use App\Model\CancellationReason;
use App\Model\KitchenFood;
use App\Model\Order;
use App\Model\OrderHistory;
use App\Model\OrderStatus;
use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SmsHelper;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer_id = $request->user('api-customer')->id;
        $orders = Order::with('status', 'kitchen', 'reviews')->whereCustomerId($customer_id)->orderBy('id', 'desc')->where('order_status_id', '<>', 0)->get();
        $customerOrders = [];
        // return response()->json($orders);
        foreach ($orders as $key => $order) {
            $rating = 0;
            $isRated = false;
            if (!empty($order->reviews) && $order->reviews->count()) {
                $rating = $order->reviews->rating;
                $isRated = true;
            }
            $customerOrders[$key] = [
                'id' => $order->id,
                'invoicePrefix' => $order->invoice_prefix,
                'kitchenName' => $order->kitchen_name,
                'kitchenId' => $order->kitchen_id,
                'total' => $order->total,
                'statusId' => $order->status->id,
                'statusName' => ($order->delivery_type == 0 ? $order->status->name : $order->status->name_2),
                'rating' => $rating,
                'isRated' => $isRated,
                'orderTime' => date('d/m/Y h:i A', strtotime($order->created_at)),
                'image' => $order->kitchen ? (!empty($order->kitchen->getMedia('kitchen')->first()) ? $order->kitchen->getMedia('kitchen')->first()->getUrl() : '') : '',
            ];
        }
        return response()->json(['orders' => $customerOrders]);
    }
    public function addOrderRating(Request $request)
    {
        Review::create([
            'customer_id' => $request->user('api-customer')->id,
            'order_id' => $request->order_id,
            'kitchen_id' => $request->kitchen_id,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);
        return response()->json(['status' => true], 201);
    }
    public function getOrderDetail(Request $request)
    {
        $customer_id = $request->user('api-customer')->id;
        $order = Order::with('food', 'kitchen', 'status', 'reviews', 'histories', 'payment')->whereCustomerId($customer_id)->whereId($request->order_id)->first();
        $orderFoods = [];
        $foods = $order->food;
        foreach ($foods as $food) {
            $orderFoods[] = [
                'name' => $food->name,
                'quantity' => $food->quantity,
                'price' => $food->price,
                'total' => $food->total,
            ];
        }
        $payment = $order->payment->first();
        $cancelStatus = 0;
        $cancellation = '';
        if ($order->order_status_id == 6) {
            $cancelStatus = 1;
            $cancellation = OrderHistory::where('order_id', $request->order_id)->where('order_status_id', 6)->first();
        }
        $rejectStatus = 0;
        $rejectReason = '';
        if ($order->order_status_id == 7) {
            $rejectStatus = 1;
            $rejectReason = OrderHistory::where('order_id', $request->order_id)->where('order_status_id', 7)->first();
        }
        $orderDetails = [];
        $orderDetails = [
            'id' => $order->id,
            'invoice_prefix' => $order->invoice_prefix,
            'title' => 'Order #' . $order->id,
            'status' => ($order->delivery_type == 0 ? $order->status->name : $order->status->name_2),
            'statusId' => $order->status->id,
            'shipping_address_1' => $order->shipping_address_1,
            'shipping_address_2' => $order->shipping_address_2,
            'shipping_city' => $order->shipping_city,
            'shipping_locality' => $order->shipping_locality,
            'kitchen_name' => $order->kitchen_name,
            'kitchen_id' => $order->kitchen_id,
            'kitchen_address_1' => $order->kitchen->address_line_1,
            'kitchen_address_2' => $order->kitchen->address_line_2,
            'kitchen_city' => $order->kitchen->city,
            'kitchen_phone' => $order->kitchen->phone,
            'delivery_type' => $order->delivery_type,
            'order_total' => $order->order_total,
            'coupon_discount' => $order->coupon_discount,
            'delivery_charge' => $order->delivery_charge,
            'total' => $order->total,
            'paymentMode' => !empty($payment) ? $payment->payment_mode : '',
            'cancellationStatus' => $cancelStatus,
            'cancelReason' => $cancellation,
            'rejectStatus' => $rejectStatus,
            'rejectReason' => $rejectReason,
            'review_description' => $order->reviews ? $order->reviews->description : '',
            'review_rating' => $order->reviews ? $order->reviews->rating : 0,
            'statusDate' => $order->histories->where('order_status_id', $order->status->id)->first() ? date('d/m/Y h:i A', strtotime(($order->histories->where('order_status_id', $order->status->id)->first())->created_at)) : date('d/m/Y h:i A', strtotime($order->created_at)),
        ];
        return response()->json(['order_details' => $orderDetails, 'foods' => $orderFoods]);
    }
    public function orderStatus(Request $request)
    {
        //$order=Order::with('orderStatus','delivery')->whereId($request->order_id)->first();
        $deliveryInfo = [];
        $order = Order::with('status', 'deliveryPartner', 'kitchen')->whereId($request->order_id)->first();
        $orderDetails = [];
        $orderDetails = [
            'id' => $order->id,
            'invoicePrefix' => $order->invoice_prefix,
            'kitchenId' => $order->kitchen_id,
            'kitchen_name' => $order->kitchen_name,
            'status' => ($order->delivery_type == 0 ? $order->status->name : $order->status->name_2),
            'statusId' => $order->status->id,
            'delivery_type' => $order->delivery_type,
            'payment_type' => $order->payment_type,
        ];
        $directionCoords = [];
        $directionCoords = [
            'customer_latitude' => $order->shipping_latitude,
            'customer_longitude' => $order->shipping_longitude,
            'kitchen_latitude' => $order->kitchen->latitude,
            'kitchen_longitude' => $order->kitchen->longitude,
        ];
        if ($order->delivery_type == 2) {
            $deliveryInfo = [
                'delivery_partner_name' => $order->deliveryPartner ? $order->deliveryPartner->name : '',
                'delivery_partner_phone' => $order->deliveryPartner ? $order->deliveryPartner->phone : '',
            ];
        } elseif ($order->delivery_type == 1) {
            $deliveryInfo = [
                'delivery_partner_name' => $order->kitchen_name,
                'delivery_partner_phone' => $order->kitchen->phone,
            ];
        }

        if ($order->order_status_id > 5) {
            $orderStatus = OrderStatus::get();
        } else {
            $orderStatus = OrderStatus::where('id', '<', 5)->get();
        }
        $orderHistory = OrderHistory::with('status')->where('order_id', $request->order_id)->get();

        $orderHistoryArray = OrderHistory::where('order_id', $request->order_id)->get()->pluck('order_status_id')->toArray();

        $newArray = [];
        $i = 0;
        // $orderHistory=$orderHistory->unique('order_status_id');
        $history_status = [];
        foreach ($orderHistory as $key => $status) {
            if (!in_array($status->order_status_id, $history_status)) {
                if ($order->order_status_id == $status->order_status_id) {
                    $newArray[$i]['current'] = 1;
                } else {
                    $newArray[$i]['current'] = 0;
                }

                $history_status[] = $status->order_status_id;
                $newArray[$i]['status'] = $status->status;
                $newArray[$i]['statusName'] = $order->delivery_type == 0 ? $status->status->name : $status->status->name_2;
                $newArray[$i]['history'] = 1;
                $newArray[$i]['comment'] = $status->comment;
                $i++;
            }
        }
        $orderStatus = OrderStatus::whereNotIn('id', $orderHistoryArray)->where('id', '<=', 5)->get()->toArray();
        foreach ($orderStatus as $key1 => $status1) {
            $newArray[$i]['status'] = $status1;
            $newArray[$i]['statusName'] = $order->delivery_type == 0 ? $status1['name'] : $status1['name_2'];
            $newArray[$i]['current'] = 0;
            $newArray[$i]['history'] = 0;
            $newArray[$i]['comment'] = $order->delivery_type == 0 ? $status1['name'] : $status1['name_2'];
            $i++;
        }

        return response()->json([
            'delivery' => $deliveryInfo,
            'orderStatus' => $orderStatus,
            'order' => $orderDetails,
            'orderHistory' => $orderHistory,
            'statusArray' => $newArray,
            'coordinates' => $directionCoords,

        ]);
    }
    public function orderTracking(Request $request)
    {
        $deliveryInfo = [];
        $order = Order::with('status', 'deliveryPartner', 'kitchen')->whereId($request->order_id)->first();

        $orderDetails = [];
        $orderDetails = [
            'id' => $order->id,
            'title' => 'order #' . $order->id,
            'kitchen_name' => $order->kitchen_name,
            'status' => $order->status->name,
            'statusId' => $order->status->id,
            'delivery_type' => $order->delivery_type,
            'payment_type' => $order->payment_type,
        ];
        $directionCoords = [];
        $directionCoords = [
            'customer_latitude' => $order->shipping_latitude,
            'customer_longitude' => $order->shipping_longitude,
            'kitchen_latitude' => $order->kitchen->latitude,
            'kitchen_longitude' => $order->kitchen->longitude,
        ];
        if ($order->delivery_type == 2) {
            $deliveryInfo = [
                'delivery_partner_name' => $order->deliveryPartner->name,
                'delivery_partner_phone' => $order->deliveryPartner->phone,
            ];
        } elseif ($order->delivery_type == 0) {
            $deliveryInfo = [
                'delivery_partner_name' => $order->kitchen_name,
                'delivery_partner_phone' => $order->kitchen->phone,
            ];
        }

        if ($order->order_status_id > 5) {
            $orderStatus = OrderStatus::get();
        } else {
            $orderStatus = OrderStatus::where('id', '<=', 5)->get();
        }

        $orderHistory = OrderHistory::with('status')->where('order_id', $request->order_id)->get();

        $orderHistoryArray = OrderHistory::where('order_id', $request->order_id)->get()->pluck('order_status_id')->toArray();

        $newArray = [];
        $i = 0;
        // $orderHistory=$orderHistory->unique('order_status_id');
        $history_status = [];
        foreach ($orderHistory as $key => $status) {
            if (!in_array($status->order_status_id, $history_status)) {
                if ($status->status->id != 5) {
                    $history_status[] = $status->order_status_id;
                    $newArray[$i]['status'] = $status->status;
                    $newArray[$i]['history'] = 2;
                    $newArray[$i]['comment'] = $status->comment;
                    $i++;
                } elseif ($order->status->id == 5) {
                    $history_status[] = $status->order_status_id;
                    $newArray[$i]['status'] = $status->status;
                    $newArray[$i]['history'] = 2;
                    $newArray[$i]['comment'] = $status->comment;
                    $i++;
                }
            }
        }
        $newArray[$i - 1]['history'] = 1;
        if ($order->status->id != 5) {
            $orderStatus = OrderStatus::whereNotIn('id', $orderHistoryArray)->where('id', '<=', 5)->get()->toArray();
            //  dd($orderStatus);
            foreach ($orderStatus as $key1 => $status1) {
                if ($status1['id'] != 5) {
                    $newArray[$i]['status'] = $status1;
                    $newArray[$i]['history'] = 0;
                    $newArray[$i]['comment'] = $status1['name'];
                    $i++;
                }

            }

        }

        return response()->json([
            'delivery' => $deliveryInfo,
            'orderStatus' => $orderStatus,
            'order' => $orderDetails,
            'orderHistory' => $orderHistory,
            'statusArray' => $newArray,
            'coordinates' => $directionCoords,

        ]);
    }
    public function getCancellationReasons(Request $request)
    {
        $reasons = CancellationReason::get();
        return response()->json(['reasons' => $reasons]);
    }
    public function cancelOrder(Request $request)
    {
        //dd($request->order_id);
        $order = Order::with('food')->whereId($request->order_id)->first();

        if ($order->order_status_id > 1) {
            return response()->json(['error' => 'Your order is either canceled or has already processed'], 422);
        }
        $reason = CancellationReason::where('id', $request->reason_id)->first();
        $comments = $reason->name . ' : ' . $request->remarks;
        $request->merge(['comment' => $comments, 'notify_email' => 1, 'order_status_id' => 6]);
        OrderHistory::create($request->all());

        $order = Order::with(['kitchen', 'food', 'histories' => function ($query) {
            $query->where('order_status_id', 6)->first();
        }])->whereId($request->order_id)->first();

        $order->update(['order_status_id' => 6]);

        $foods = $order->food;

        foreach ($foods as $food) {
            $kitchenFood = KitchenFood::find($food->kitchen_food_id);
            if ($kitchenFood) {
                $kitchenFood->increment('quantity', $food->quantity);
            }
        }

        $statusname = 'Cancelled';
        $title = $order->invoice_prefix . $order->id . ' : ' . $statusname;
        $body = 'Your order ' . $order->invoice_prefix . $order->id . ' has been Cancelled';

        // $status = PushNotificationHelper::notify($title,$body,['orderId' => $order->id],[$order->customer_id],'OrderDetail',1);

        //  $PushNotification = Notification::create([

        //     'title'=>$title,
        //   // 'user_id'=>$order->customer_id,
        //      'user_type'=>3,
        //      'created_by'=>3,
        //     'parameter'=>$order->id,
        //     'route'=>'OrderDetail',
        //     'status'=>7,
        //     'message'=>$body
        // ]);

        Mail::to($order->email, $order->name)->send(new CancelOrder($order));
        Mail::to($order->kitchen->email, $order->kitchen->name)->send(new CancelOrderKitchen($order));
        SmsHelper::send($order->phone, 'Your order has been cancelled successfully. Let us know if you need any help');

        return response()->json(['success' => 'Your order has been successfully canceled']);
    }
}
