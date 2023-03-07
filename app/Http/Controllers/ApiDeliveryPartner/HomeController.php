<?php

namespace App\Http\Controllers\ApiDeliveryPartner;

use App\Http\Controllers\Controller;
use App\Model\AssignedDelivery;
use App\Model\Country;
use App\Model\DeliveryPartner;
use App\Model\DeliveryPartnerBank;
use App\Model\DeliveryPartnerPayouts;
use App\Model\DeliveryStatus;
use App\Model\Feedback;
use App\Model\Information;
use App\Model\Kitchen;
use App\Model\Order;
use App\Model\OrderDeliveryHistory;
use App\Model\OrderHistory;
use App\Model\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MediaUploader;
use Plank\Mediable\Media;
use PushNotificationHelper;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|max:12',
            'addressLine1' => 'required|string|max:255',
            'addressLine2' => 'required|string|max:255',
            'streetName' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'city' => 'required|string|max:25',
            'latitude' => 'required',
            'longitude' => 'required',
            'pincode' => 'required|string|max:25',
            'country' => 'required',
            'state' => 'required',

        ]);
        $deliveryPartner = DeliveryPartner::where('id', $request->user('api-deliveryPartner')->id)->first();
        $country_id = Country::where('iso_code_2', $request->country)->first()->id;
        $deliveryPartner->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address_line_1' => $request->addressLine1,
            'address_line_2' => $request->addressLine2,
            'street_name' => $request->streetName,
            'landmark' => $request->landmark,
            'country_id' => $country_id,
            'state_id' => State::where('code', $request->state)->where('country_id', $country_id)->first()->id,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        DeliveryPartnerBank::create([
            'delivery_partner_id' => $request->user('api-deliveryPartner')->id,
        ]);
        return response()->json(['deliveryPartner' => $deliveryPartner,
            'message' => 'User has been successfully created!',
        ], 201);
    }
    public function addKYC(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'idNumber' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'proofFiles' => 'required',
        ]);
        $deliveryPartner = DeliveryPartner::where('id', $request->user('api-deliveryPartner')->id)->first();
        $deliveryPartner->update([
            'kyc_name' => $request->name,
            'kyc_id_number' => $request->idNumber,
            'kyc_proof' => $request->type,
        ]);
        if (!empty($request->file('proofFiles'))) {
            $files = $request->file('proofFiles');
            foreach ($files as $value1) {
                $time = time();
                $filename = 'CHEF' . $time;
                $mediafiles = MediaUploader::fromSource($value1)
                    ->useFilename($filename)
                    ->toDirectory('deliveryPartner/' . $deliveryPartner->id . '/proof')
                    ->upload();
                $deliveryPartner->attachMedia($mediafiles, ['proof']);
            }
        }
        return response()->json(['deliveryPartner' => $deliveryPartner,
            'message' => 'User has been successfully created!',
        ], 201);
    }
    public function fileDelete(Request $request)
    {
        $image = Media::whereId($request->id)->first();
        if ($image->delete()) {
            return response()->json([
                'status' => 'success',
            ], 201);
        } else {
            return response()->json(['status' => 'failed'], 401);
        }
    }
    public function addBank(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'ifsc' => 'required|string|max:255',
            'accountNumber' => 'required|string|max:255',
        ]);
        $deliveryPartnerBank = DeliveryPartnerBank::where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->first();
        $deliveryPartnerBank->update([
            'bank_name' => $request->name,
            'branch' => $request->branch,
            'swift' => $request->swift,
            'ifsc' => $request->ifsc,
            'account_number' => $request->accountNumber,

        ]);
        $deliveryPartner = DeliveryPartner::where('id', $request->user('api-deliveryPartner')->id)->first();
        $deliveryPartner->update([
            'approval_request_date' => date('Y-m-d'),
        ]);
        return response()->json([
            'message' => 'Bank successfully added!',
        ], 201);
    }

    public function todayTasks(Request $request)
    {
        $orders = Order::with('kitchen')->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('delivery_status_id', '<', 3)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
        $todayTask = [];

        foreach ($orders as $order) {

            if ($order) {
                $foods = $order->food;

                foreach ($foods as $food) {
                    $orderFoods[] = [
                        'name' => $food->name,
                        'quantity' => $food->quantity,
                    ];
                }
                $todayTask = [
                    'id' => $order->id,
                    'invoicePrefix' => $order->invoice_prefix,
                    'items' => $orderFoods,
                    'kitchenName' => $order->kitchen_name,
                    'kitchenAddress' => $order->kitchen->address_line_1 . ',' . $order->kitchen->landmark . ',' . $order->kitchen->street_name,
                    'customerName' => $order->name,
                    'customerAddress' => $order->shipping_address_2,
                    'kitchenLatitude' => $order->kitchen->latitude,
                    'kitchenLongitude' => $order->kitchen->longitude,
                    'customerLatitude' => $order->latitude,
                    'customerLongitude' => $order->longitude,
                    'deliveryStatus' => $order->delivery_status_id,
                ];
            }
        }

        return response()->json(['todayTask' => $todayTask]);
    }

    public function completedTasks(Request $request)
    {

        file_put_contents('filter.txt', "");
        error_log(json_encode($request->all()), 3, 'filter.txt');

        $orders = Order::with(['kitchen', 'deliveryStatus', 'deliveryHistories'])->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('delivery_status_id', 3)->where(function ($query) use ($request) {

            if ($request->filter == 'today') {

                $query->whereDate('created_at', date('Y-m-d'));

            } else if ($request->filter == 'week') {

                $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));

            } else if ($request->filter == 'month') {

                $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));

            } else if ($request->filter == 'year') {

                $query->whereYear('created_at', date('Y'));
            }

        })->orderBy('id', 'desc')->get();

        $completedTasks = [];
        foreach ($orders as $key => $order) {
            $completed_time = $order->deliveryHistories->sortByDesc('created_at');

            $completedTasks[$key] = [
                'id' => $order->id,
                'invoicePrefix' => $order->invoice_prefix,
                'deliveryCharge' => $order->delivery_charge,
                'deliveryTime' => $completed_time ? date('d-m-y h:i A', strtotime($completed_time[0]->created_at)) : '',

                'deliveryStatus' => $order->deliveryStatus->name,
                'invoicePrefix' => $order->invoice_prefix,
                'total' => $order->delivery_charge,
                'kitchenName' => $order->kitchen_name,
                'address' => $order->kitchen->address_line_1 . ',' . $order->kitchen->landmark . ',' . $order->kitchen->street_name,
                'customerName' => $order->name,
                'customerAddress' => $order->payment_address_line_1 . ',' . $order->payment_landmark,
            ];
        }
        return response()->json(['completedTasks' => $completedTasks]);
    }

    public function orderDetail(Request $request)
    {
        $order = Order::with('kitchen', 'deliveryStatus')->where('id', $request->id)->first();
        $todayTasks = [];
        $foods = $order->food;
        foreach ($foods as $food) {
            $orderFoods[] = [
                'name' => $food->name,
                'quantity' => $food->quantity,
            ];
        }
        $orderDetail = [
            'id' => $order->id,
            'invoicePrefix' => $order->invoice_prefix,
            'items' => $orderFoods,
            'kitchenName' => $order->kitchen_name,
            'kitchenAddress' => $order->kitchen->address_line_1 . ',' . $order->kitchen->landmark . ',' . $order->kitchen->street_name,
            'customerName' => $order->name,
            'customerAddress' => $order->shipping_address_2,
            'customerLandmark' => $order->shipping_landmark,
            'customerDoor' => $order->shipping_address_1,
            'deliveryStatusId' => $order->delivery_status_id,
            'deliveryStatusName' => DeliveryStatus::where('id', $order->delivery_status_id)->first()->name,
            'kitchenLatitude' => $order->kitchen->latitude,
            'kitchenLongitude' => $order->kitchen->longitude,
            'customerLatitude' => $order->shipping_latitude,
            'customerLongitude' => $order->shipping_longitude,
        ];
        return response()->json(['orderDetail' => $orderDetail]);
    }
    public function pickupDetail(Request $request)
    {
        $order = Order::with('kitchen', 'deliveryStatus')->where('id', $request->id)->first();
        $todayTasks = [];
        $foods = $order->food;
        foreach ($foods as $food) {
            $orderFoods[] = [
                'name' => $food->name,
                'quantity' => $food->quantity,
            ];
        }
        $orderDetail = [
            'id' => $order->id,
            'invoicePrefix' => $order->invoice_prefix,
            'items' => $orderFoods,
            'kitchenName' => $order->kitchen_name,
            'kitchenAddress' => $order->kitchen->address_line_1 . ',' . $order->kitchen->landmark . ',' . $order->kitchen->street_name,
            'customerName' => $order->name,
            'kitchenPhone' => $order->kitchen->phone,
            'customerAddress' => $order->shipping_address_2,
            'customerLandmark' => $order->shipping_landmark,
            'customerDoor' => $order->shipping_address_1,
            'deliveryStatusId' => $order->delivery_status_id + 1,
            'deliveryStatusName' => DeliveryStatus::where('id', $order->delivery_status_id + 1)->first()->name,
            'kitchenLatitude' => $order->kitchen->latitude,
            'kitchenLongitude' => $order->kitchen->longitude,
            'customerLatitude' => $order->shipping_latitude,
            'customerLongitude' => $order->shipping_longitude,
            'orderStatusId' => $order->order_status_id,
        ];
        return response()->json(['orderDetail' => $orderDetail]);
    }
    public function deliveryDetail(Request $request)
    {
        $order = Order::with('kitchen', 'deliveryStatus')->where('id', $request->id)->first();
        $todayTasks = [];
        $foods = $order->food;
        foreach ($foods as $food) {
            $orderFoods[] = [
                'name' => $food->name,
                'quantity' => $food->quantity,
            ];
        }
        $orderDetail = [
            'id' => $order->id,
            'invoicePrefix' => $order->invoice_prefix,
            'items' => $orderFoods,
            'kitchenName' => $order->kitchen_name,
            'kitchenAddress' => $order->kitchen->address_line_1 . ',' . $order->kitchen->landmark . ',' . $order->kitchen->street_name,
            'customerName' => $order->name,
            'customerPhone' => $order->phone,
            'customerAddress' => $order->shipping_address_2,
            'customerLandmark' => $order->shipping_landmark,
            'customerDoor' => $order->shipping_address_1,
            'deliveryStatusId' => $order->delivery_status_id == 3 ? $order->delivery_status_id : $order->delivery_status_id + 1,
            'deliveryStatusName' => DeliveryStatus::where('id', $order->delivery_status_id == 3 ? $order->delivery_status_id : $order->delivery_status_id + 1)->first()->name,
            'kitchenLatitude' => $order->kitchen->latitude,
            'kitchenLongitude' => $order->kitchen->longitude,
            'customerLatitude' => $order->shipping_latitude,
            'customerLongitude' => $order->shipping_longitude,
            'orderStatusId' => $order->order_status_id,
        ];
        return response()->json(['orderDetail' => $orderDetail]);
    }

    public function updateDeliveryStatus(Request $request)
    {
        $message = "";
        $order = Order::where('id', $request->id)->first();
        $order->update(['delivery_status_id' => $request->status]);

        if ($request->status == 1) {
            $message = "Order Accepted";
        } else if ($request->status == 2) {
            $message = "Order Picked Up";
            $order->update(['order_status_id' => 4]);
            OrderDeliveryHistory::create(['order_id' => $order->id, 'delivery_status_id' => 2, 'comment' => 'Order picked up for delivery']);
            OrderHistory::create(['order_id' => $order->id, 'order_status_id' => 4, 'comment' => 'Order Picked Up']);
            $title = $order->invoice_prefix . $order->id . ': Order Picked Up';
            $status = PushNotificationHelper::notify($title, 'Your order has been  Picked Up ', ['orderId' => $order->id], [$order->customer_id], 'OrderDetail', 1);
        } else if ($request->status == 3) {
            $order->update(['order_status_id' => 5]);
            $message = "Order Delivered";
            OrderDeliveryHistory::create(['order_id' => $order->id, 'delivery_status_id' => 3, 'comment' => 'Order delivered']);
            OrderHistory::create(['order_id' => $order->id, 'order_status_id' => 5, 'comment' => 'Order delivered']);
            $title = $order->invoice_prefix . $order->id . ': Order Delivered';
            $status = PushNotificationHelper::notify($title, 'Your order has been Delivered ', ['orderId' => $order->id], [$order->customer_id], 'OrderDetail', 1);
        }

        return response()->json(['status' => $order->delivery_status_id, 'message' => $message], 201);
    }

    /**
     * Update  availablity status.
     *
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request)
    {
        $deliveryPartner = DeliveryPartner::where('id', $request->user('api-deliveryPartner')->id)->first();
        if ($deliveryPartner->availability_status == 1) {
            $deliveryPartner->update(['availability_status' => 0]);
        } else {
            $deliveryPartner->update(['availability_status' => 1]);
        }

        return response()->json(['status' => $deliveryPartner->availability_status], 201);
    }
    /**
     * Get  availablity status.
     *
     * @return \Illuminate\Http\Response
     */

    public function getStatus(Request $request)
    {
        $availabilityStatus = DeliveryPartner::where('id', $request->user('api-deliveryPartner')->id)->first()->availability_status;
        return response()->json(['status' => $availabilityStatus]);
    }

    /**
     * Get all earnings Details.
     *
     * @return \Illuminate\Http\Response
     */

    public function getEarnings(Request $request)
    {
        $orders = Order::with('kitchen')->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('order_status_id', 5)->orderBy('id', 'desc')->get();

        $completedTasks = [];

        $totalEarnings = Order::where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('order_status_id', 5)->sum('delivery_charge');
        $totalPaid = Order::where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('order_status_id', 5)->sum('delivery_charge');

        $pending = Order::where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->whereDate('created_at', '=', Carbon::today()->toDateString())->sum('delivery_charge');

        foreach ($orders as $key => $order) {
            $completedTasks[$key] = [
                'id' => $order->id,
                'total' => $order->delivery_charge,
                'orderTime' => date('h:i A', strtotime($order->created_at)),
                'orderDate' => date('d F Y ', strtotime($order->created_at)),
                'itemCount' => count($order->food),
            ];
        }
        return response()->json(['completedTasks' => $completedTasks, 'totalEarnings' => $totalEarnings, 'totalPaid' => $totalPaid, 'pending' => $pending]);
    }

    /**
     * Get Profile Details.
     *
     * @return \Illuminate\Http\Response
     */

    public function getProfile(Request $request)
    {
        $deliveryPartner = DeliveryPartner::with(['bank', 'state', 'country'])->where('id', $request->user('api-deliveryPartner')->id)->first();

        return response()->json(['deliveryPartner' => $deliveryPartner, 'deliveryPartnerBank' => $deliveryPartner->bank, 'kyc' => $deliveryPartner->kyc_proof]);
    }

    /**
     * Store data form help form.
     *
     * @return \Illuminate\Http\Response
     */

    public function submitHelp(Request $request)
    {
        Feedback::create([

            'delivery_partner_id' => $request->user('api-deliveryPartner')->id,
            'title' => $request->phone,
            'type' => '2',
            'description' => $request->message,
        ]);
        return response()->json(['status' => true], 201);
    }

    /**
     * Update Delivery partner location.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLocation(Request $request)
    {

        file_put_contents('updatelocationDelivery.txt', "");
        error_log(json_encode($request->all()), 3, 'updatelocationDelivery.txt');

        $deliveryPartner = DeliveryPartner::whereId($request->user('api-deliveryPartner')->id)->first();
        $deliveryPartner->update([
            'last_latitude' => $request->latitude,
            'last_longitude' => $request->longitude,
            'location_updated_at' => date("Y-m-d H:i:s"),
        ]);
        return response()->json(['status' => 'success']);
    }

    /**
     * Accept the delivery request from the customer before order.
     *
     * @return \Illuminate\Http\Response
     */

    public function acceptOrder(Request $request)
    {
        $id = $request->id;
        $delivery = AssignedDelivery::whereId($request->id)->first();

        $temp_id = $delivery->order_temp_id;

        $check_accepted = AssignedDelivery::where('order_temp_id', $temp_id)->where('active_status', 1)->where('accept_status', 1)->first();

        if (empty($check_accepted)) {
            $delivery = AssignedDelivery::where('id', $id)->where('active_status', 1)->first();
            if (!empty($delivery)) {
                $delivery->update(['accept_status' => 1, 'accepted_date' => Carbon::now()]);

                AssignedDelivery::where('order_temp_id', $temp_id)->where('active_status', 1)->where('accept_status', 0)->update(['active_status' => 0]);

                $deliveryRequestArray = [];
                $delivery_requests = AssignedDelivery::with(['kitchen', 'customerAddress'])->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('accept_status', 0)->where('active_status', 1)->whereDate('created_at', Carbon::today())->get();
                foreach ($delivery_requests as $delivery_request) {
                    $deliveryRequestArray[] = [
                        'requestId' => $delivery_request->id,
                        'pickupTime' => $delivery_request->pickup_time ? date("h:i A", strtotime($delivery_request->pickup_time)) : '',
                        'kitchenName' => $delivery_request->kitchen->name,
                        'kitchenAddress' => $delivery_request->kitchen->address_line_1 . ',' . $delivery_request->kitchen->landmark . ',' . $delivery_request->kitchen->street_name,
                        'customerName' => $delivery_request->customerAddress->name,
                        'customerAddress' => $delivery_request->customerAddress->address_line_1 . ', ' . $delivery_request->customerAddress->landmark . ', ' . $delivery_request->customerAddress->street_name,
                        'kitchenLatitude' => $delivery_request->kitchen->latitude,
                        'kitchenLongitude' => $delivery_request->kitchen->longitude,
                        'customerLatitude' => $delivery_request->customerAddress->latitude,
                        'customerLongitude' => $delivery_request->customerAddress->longitude,

                    ];
                }
                return response()->json(['status' => 1, 'deliveryRequests' => $deliveryRequestArray, 'message' => 'Order accepted successfully'], 201);
            } else {
                return response()->json(['status' => 0, 'message' => 'Delivery request is expired'], 201);
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Order already accepted by someone else'], 201);
        }

        // $deliveryPartner=DeliveryPartner::where('id',$request->user('api-deliveryPartner')->id)->first();
    }

    /**
     * Get  the delivery request from the customer before order.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDeliveryRequests(Request $request)
    {

        $deliveryRequestArray = [];
        $delivery_requests = AssignedDelivery::with(['kitchen', 'customerAddress'])->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('accept_status', 0)->where('active_status', 1)->whereDate('created_at', Carbon::today())->get();
        foreach ($delivery_requests as $delivery_request) {
            $deliveryRequestArray[] = [
                'requestId' => $delivery_request->id,
                'pickupTime' => $delivery_request->pickup_time ? date("h:i A", strtotime($delivery_request->pickup_time)) : '',
                'kitchenName' => $delivery_request->kitchen->name,
                'kitchenAddress' => $delivery_request->kitchen->address_line_1 . ',' . $delivery_request->kitchen->landmark . ',' . $delivery_request->kitchen->street_name,
                'customerName' => $delivery_request->customerAddress->name,
                'customerAddress' => $delivery_request->customerAddress->address_line_1 . ', ' . $delivery_request->customerAddress->landmark . ', ' . $delivery_request->customerAddress->street_name,
                'kitchenLatitude' => $delivery_request->kitchen->latitude,
                'kitchenLongitude' => $delivery_request->kitchen->longitude,
                'customerLatitude' => $delivery_request->customerAddress->latitude,
                'customerLongitude' => $delivery_request->customerAddress->longitude,
            ];
        }

        return response()->json(['deliveryRequests' => $deliveryRequestArray]);
    }

    /**
     * Get All delivery request of delivery partner with filter.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllDeliveryRequests(Request $request)
    {
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $deliveryRequestArray = [];
        $delivery_requests = AssignedDelivery::with(['kitchen', 'customerAddress', 'order.status', 'order.deliveryStatus'])->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)
            ->where(function ($query) use ($request, $to, $from) {

                // if(isset($request->from)||isset($request->to)) {
                if (isset($request->filter) && empty($request->filter)) {
                    $query->where('created_at', '>=', $from)->where('created_at', '<=', $to);
                } else {
                    if ($request->filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    } else if ($request->filter == 'week') {
                        $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                    } else if ($request->filter == 'month') {
                        $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                    } else if ($request->filter == 'year') {
                        $query->whereYear('created_at', date('Y'));
                    }
                }
            })->orderBy('id', 'desc')->get();

        foreach ($delivery_requests as $delivery_request) {
            $order = '';

            $status = '';
            if (!$delivery_request->active_status) {
                $status = 'Cancelled';
            }

            if (!empty($delivery_request->order)) {

                $order = [
                    'id' => $delivery_request->order->id,
                    'invoicePrefix' => $delivery_request->order->invoice_prefix,
                    'total' => $delivery_request->order->delivery_charge,
                    'kitchenName' => $delivery_request->order->kitchen_name,
                    'statusId' => $delivery_request->order->order_status_id,
                    'address' => $delivery_request->order->kitchen->address_line_1 . ',' . $delivery_request->order->kitchen->landmark . ',' . $delivery_request->order->kitchen->street_name,
                ];

                if ($delivery_request->active_status) {
                    $status = $delivery_request->order->status ? $delivery_request->order->status->name : 'Order Pending';
                }
                if ($delivery_request->order->delivery_status_id > 1) {

                    $status = $delivery_request->order->deliveryStatus->name;
                }
            }
            $deliveryRequestArray[] = [
                'orderStatus' => $status,
                'requestId' => $delivery_request->id,
                'pickupTime' => $delivery_request->pickup_time ? date("h:i A", strtotime($delivery_request->pickup_time)) : '',
                'acceptStatus' => $delivery_request->accept_status,
                'activeStatus' => $delivery_request->active_status,
                'acceptedDate' => $delivery_request->accepted_date,
                'kitchenName' => $delivery_request->kitchen->name,
                'kitchenAddress' => $delivery_request->kitchen->address_line_1 . ',' . $delivery_request->kitchen->landmark . ',' . $delivery_request->kitchen->street_name,
                // 'customerName'=>$delivery_request->customerAddress->name,
                // 'customerAddress'=>$delivery_request->customerAddress->address_line_1.','.$delivery_request->customerAddress->landmark.','.$delivery_request->customerAddress->street_name,
                'kitchenLatitude' => $delivery_request->kitchen->latitude,
                'kitchenLongitude' => $delivery_request->kitchen->longitude,
                // 'customerLatitude'=>$delivery_request->customerAddress->latitude,
                // 'customerLongitude'=>$delivery_request->customerAddress->longitude,
                'orderDetails' => $order,
            ];
        }
        return response()->json(['requestDetails' => $deliveryRequestArray]);
    }

    public function getPendingOrders(Request $request)
    {

        $delivery_requests = AssignedDelivery::with(['kitchen', 'customerAddress', 'order.status', 'order.deliveryStatus'])->where(function ($query) {
            $query->whereHas('order.deliveryStatus', function ($query) {
                $query->Where('id', '<', 3);
            });
        })->where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('accept_status', 1)->whereDate('created_at', Carbon::today())->get();

        $pendingOrders = [];

        foreach ($delivery_requests as $delivery_request) {
            $order = [];
            $status = '';
            if (!$delivery_request->active_status) {
                $status = 'cancelled';
            }
            if (!empty($delivery_request->order)) {
                $order = [
                    'id' => $delivery_request->order->id,
                    'invoicePrefix' => $delivery_request->order->invoice_prefix,
                    'total' => $delivery_request->order->delivery_charge,
                    'statusId' => $delivery_request->order->order_status_id,
                    'kitchenName' => $delivery_request->order->kitchen_name,
                    'address' => $delivery_request->order->kitchen->address_line_1 . ',' . $delivery_request->order->kitchen->landmark . ',' . $delivery_request->order->kitchen->street_name,
                ];

                if ($delivery_request->active_status) {
                    $status = $delivery_request->order->status ? $delivery_request->order->status->name : 'Order Pending';
                }
                if ($delivery_request->order->delivery_status_id > 1) {
                    $status = $delivery_request->order->deliveryStatus->name;
                }
            }
            $pendingOrders[] = [
                'orderStatus' => $status,
                'pickupTime' => $delivery_request->pickup_time ? date("h:i A", strtotime($delivery_request->pickup_time)) : '',
                'requestId' => $delivery_request->id,
                'acceptStatus' => $delivery_request->accept_status,
                'activeStatus' => $delivery_request->active_status,
                'acceptedDate' => $delivery_request->accepted_date,
                'kitchenName' => $delivery_request->kitchen->name,
                'kitchenAddress' => $delivery_request->kitchen->address_line_1 . ',' . $delivery_request->kitchen->landmark . ',' . $delivery_request->kitchen->street_name,
                'customerName' => $delivery_request->customerAddress->name,
                'customerAddress' => $delivery_request->customerAddress->address_line_1 . ',' . $delivery_request->customerAddress->landmark . ',' . $delivery_request->customerAddress->street_name,
                'kitchenLatitude' => $delivery_request->kitchen->latitude,
                'kitchenLongitude' => $delivery_request->kitchen->longitude,
                'customerLatitude' => $delivery_request->customerAddress->latitude,
                'customerLongitude' => $delivery_request->customerAddress->longitude,
                'orderDetails' => $order,
            ];
        }
        return response()->json(['pendingOrders' => $pendingOrders]);
    }

    public function cronPayout(Request $request)
    {
        $today = Carbon::now();
        $current_date = Carbon::now()->format('Y-m-d');
        $dayOfWeek = $today->dayOfWeek;
        $partners = DeliveryPartner::with('payoutGroup', 'deliveryPartnerPayouts')->whereStatus(1)->get();
        foreach ($partners as $partner) {
            $lastPayoutDate = '';
            $nextPayoutDate = '';
            if (!empty($partner->payoutGroup)) {
                if ($partner->deliveryPartnerPayouts->count()) {
                    $lastPayoutDate = Carbon::parse($partner->deliveryPartnerPayouts->last()->payout_generated_date);
                    if ($partner->payoutGroup->payment_frequency == 1) {
                        $nextPayoutDate = $lastPayoutDate->addMonth();
                    } else {
                        $nextPayoutDate = $lastPayoutDate->addDays(7);
                    }
                } else {
                    if ($partner->payoutGroup->payment_frequency == 2) {

                        if ($dayOfWeek == ($partner->payoutGroup->day_id - 1)) {
                            $lastPayoutDate = $today->subDays(7);
                            $nextPayoutDate = $current_date;
                        }
                    } else {
                        $partnerCreatedOn = Carbon::parse($partner->created_at);
                        if ($partnerCreatedOn->addMonth() == $current_date) {
                            $lastPayoutDate = $partnerCreatedOn;
                            $nextPayoutDate = $current_date;
                        }
                    }
                }

                $lastPayoutDate = Carbon::parse($lastPayoutDate)->format('Y-m-d');
                $nextPayoutDate = Carbon::parse($nextPayoutDate)->format('Y-m-d');
                // return response()->json([$lastPayoutDate,$nextPayoutDate, $current_date]);
                if ($current_date == $nextPayoutDate) {
                    // return response()->json($current_date);
                    $orders = Order::where('delivery_partner_id', $partner->id)->whereDate('created_at', '>', $lastPayoutDate)->whereDate('created_at', '<=', $nextPayoutDate)->where('order_status_id', 5)->get();
                    if ($orders->count()) {
                        DeliveryPartnerPayouts::create([
                            'delivery_partner_id' => $partner->id,
                            'payout_group_id' => $partner->payout_group_id,
                            'total_orders' => $orders->count(),
                            'total_amount' => $orders->sum('delivery_charge'),
                            'payout_method' => 0,
                            'start_date' => $lastPayoutDate,
                            'end_date' => $nextPayoutDate,
                            'payout_generated_date' => $current_date,
                            'commission' => $orders->sum('delivery_charge') * $partner->payoutGroup->percentage / 100,
                            'payable_amount' => $orders->sum('delivery_charge') - ($orders->sum('delivery_charge') * $partner->payoutGroup->percentage / 100),
                            'status' => 0,
                        ]);
                    }
                }
            }
        }
    }

    public function getPayouts(Request $request)
    {
        $payoutArray = [];
        $partner = DeliveryPartner::with('payoutGroup')->where('id', $request->user('api-deliveryPartner')->id)->first();
        $payouts = DeliveryPartnerPayouts::where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->orderBy('payout_generated_date', 'desc')->get();
        $orders = Order::where('delivery_partner_id', $request->user('api-deliveryPartner')->id)->where('order_status_id', 5)->get();
        $totalOrderAmount = $orders->sum('delivery_charge');
        $totalOrderCount = $orders->count();
        if (!empty($partner->payoutGroup)) {
            $totalPayoutAmount = $orders->sum('delivery_charge') - ($orders->sum('delivery_charge') * ($partner->payoutGroup->percentage / 100));
        } else {
            $totalPayoutAmount = 00;
        }

        $totalPending = $totalPayoutAmount - $payouts->sum('payable_amount');

        foreach ($payouts as $payout) {
            $payoutArray[] = [
                'id' => $payout->id,
                'startDate' => Carbon::parse($payout->start_date)->format('Y-m-d'),
                'endDate' => Carbon::parse($payout->end_date)->format('Y-m-d'),
                'totalOrders' => $payout->total_orders,
                'totalAmount' => $payout->total_amount,
                'payoutGeneratedDate' => Carbon::parse($payout->payout_generated_date)->format('Y-m-d'),
                'commission' => $payout->commission,
                'payableAmount' => $payout->payable_amount,
                'transactionId' => $payout->transaction_id,
                'status' => $payout->status,
                'remarks' => $payout->remarks,
            ];
        }
        return response()->json(['payouts' => $payoutArray, 'totalOrderAmount' => $totalOrderAmount, 'totalOrderCount' => $totalOrderCount, 'totalPayoutAmount' => $totalPayoutAmount, 'totalPending' => $totalPending, 'payoutGroup' => $partner->payoutGroup]);
    }
    public function getInformation(Request $request)
    {

        $information = Information::where('id', $request->slug)->where('status', 1)->first();
        return response()->json(['information' => $information], 200);
    }

}
