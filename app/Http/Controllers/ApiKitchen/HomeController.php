<?php

namespace App\Http\Controllers\ApiKitchen;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Model\Faq;
use App\Model\FoodCategory;
use App\Model\Information;
use App\Model\Kitchen;
use App\Model\KitchenFood;
use App\Model\Notification;
use App\Model\Order;
use App\Model\OrderHistory;
use App\Model\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use MediaUploader;
use Plank\Mediable\Media;
use PushNotificationHelper;
use SmsHelper;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->status_id == '') {
            $orders = Order::with('status', 'kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', '>=', 1)->orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->get();
        } else {
            $orders = Order::with('status', 'kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', $request->status_id)->orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->get();
        }

        $kitchenOrders = [];
        foreach ($orders as $key => $order) {
            $foods = $order->food;
            $orderFoods = [];
            foreach ($foods as $food) {
                $orderFoods[] = [
                    'id' => $food->id,
                    'order_id' => $food->order_id,
                    'name' => $food->name,
                    'quantity' => $food->quantity,
                    'notes' => $food->notes,
                ];
            }
            $kitchenOrders[$key] = [
                'id' => $order->id,
                'invoicePrefix' => $order->invoice_prefix,
                'total' => $order->total,
                'statusId' => $order->status ? $order->status->id : 0,
                'statusName' => $order->delivery_type == 0 ? $order->status->name : $order->status->name_2,
                'foods' => $orderFoods,
                'orderTime' => date('h:i A', strtotime($order->created_at)),
                'orderDate' => date('d F Y ', strtotime($order->created_at)),
            ];
        }
        return response()->json(['orders' => $kitchenOrders]);
    }

    /**
     * Display a listing of all the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllOrders(Request $request)
    {
        if ($request->filter == '') {
            $orders = Order::with('status', 'kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', '>=', 1)->orderBy('id', 'desc')->get();
        } else {
            $orders = Order::with('status', 'kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', $request->filter)->orderBy('id', 'desc')->get();
        }

        $kitchenOrders = [];
        foreach ($orders as $key => $order) {
            $foods = $order->food;
            $orderFoods = [];
            foreach ($foods as $food) {
                $orderFoods[] = [
                    'id' => $food->id,
                    'order_id' => $food->order_id,
                    'name' => $food->name,
                    'quantity' => $food->quantity,
                    'notes' => $food->notes,
                ];
            }
            $kitchenOrders[$key] = [
                'id' => $order->id,
                'invoicePrefix' => $order->invoice_prefix,
                'total' => $order->total,
                'statusId' => $order->status ? $order->status->id : 0,
                'statusName' => $order->delivery_type == 0 ? $order->status->name : $order->status->name_2,
                'foods' => $orderFoods,
                'orderTime' => date('h:i A', strtotime($order->created_at)),
                'orderDate' => date('d F Y ', strtotime($order->created_at)),
            ];
        }
        return response()->json(['orders' => $kitchenOrders]);
    }

    public function getOrderDetail(Request $request)
    {
        $order = Order::with('food', 'kitchen', 'status', 'deliveryPartner', 'reviews', 'coupon')->whereId($request->order_id)->first();
        $orderFoods = [];
        $foods = $order->food;

        foreach ($foods as $food) {
            $orderFoods[] = [
                'name' => $food->name,
                'quantity' => $food->quantity,
                'notes' => $food->notes,
                'price' => $food->price,
                'total' => $food->total,
            ];
        }

        $orderDetails = [];
        $status = '';
        if ($order->delivery_type == 0) {
            $status = $order->status->name;
        } else if ($order->delivery_type == 1) {
            $status = $order->status->name_2;
        } else {
            $status = $order->status->name_3;
        }
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
        $orderDetails = [
            'id' => $order->id,
            'invoicePrefix' => $order->invoice_prefix,
            'customer_name' => $order->name,
            'customer_phone' => $order->phone,
            'title' => 'order #' . $order->id,
            'status' => $status,
            'statusId' => $order->status->id,
            'statusName' => $status,
            'orderTime' => date('h:i A', strtotime($order->created_at)),
            'orderDate' => date('d F Y ', strtotime($order->created_at)),
            'delivery_type' => $order->delivery_type,
            'order_total' => $order->order_total,
            'coupon_discount' => $order->coupon_discount,
            'shipping_latitude' => $order->shipping_latitude,
            'shipping_longitude' => $order->shipping_longitude,
            'kitchen_latitude' => $order->kitchen->latitude,
            'kitchen_longitude' => $order->kitchen->longitude,
            'delivery_partner_name' => $order->deliveryPartner ? $order->deliveryPartner->name : '',
            'delivery_partner_phone' => $order->deliveryPartner ? $order->deliveryPartner->phone : '',
            'address' => $order->payment_address_1 . ',' . $order->payment_address_2 . ',' . $order->payment_city,
            'delivery_charge' => $order->delivery_charge,
            'coupon_description' => $order->coupon ? $order->coupon->coupon->name : '',
            'shipping_latitude' => $order->shipping_latitude,
            'shipping_longitude' => $order->shipping_longitude,
            'kitchen_latitude' => $order->kitchen->latitude,
            'cancellationStatus' => $cancelStatus,
            'cancelReason' => $cancellation,
            'rejectStatus' => $rejectStatus,
            'rejectReason' => $rejectReason,
            'total' => $order->total,

        ];
        $review = [];
        if ($order->reviews != null) {
            $reviews = $order->reviews;

            $review = [
                'rating' => $reviews->rating,
                'description' => $reviews->description,
            ];
        }
        $orderStatus = orderStatus::get();
        $statusArray = [];
        $i = 0;
        foreach ($orderStatus as $status) {
            $statusArray[$i]['id'] = $status->id;
            if ($order->delivery_type == 0) {
                $statusArray[$i]['name'] = $status->name;
            } elseif ($order->delivery_type == 1) {
                $statusArray[$i]['name'] = $status->name_2;
            } else {
                $statusArray[$i]['name'] = $status->name_3;
            }
            $i = $i + 1;

        }
        return response()->json(['order_details' => $orderDetails, 'foods' => $orderFoods, 'review' => $review, 'orderStatus' => $statusArray]);
    }
    public function updateOrderStatus(Request $request)
    {
        file_put_contents('updateOrderStatus.txt', "");
        error_log(json_encode($request->all()), 3, 'updateOrderStatus.txt');
        $order = Order::with('histories')->where('id', $request->order_id)->first();
        $order->update(['order_status_id' => $request->order_status_id]);

        if ($request->order_status_id == 1) {
            $comment = 'Placed';
        } elseif ($request->order_status_id == 2) {
            $comment = 'Confirmed';
        } elseif ($request->order_status_id == 3) {
            $comment = 'Packed';
        } elseif ($request->order_status_id == 4) {
            if ($order->delivery_type == 0) {
                $comment = 'Ready';
            } else {
                $comment = 'Transit';
            }
        } elseif ($request->order_status_id == 5) {
            $comment = 'Delivered';
        } elseif ($request->order_status_id == 7) {
            $comment = 'Out of Stock';
        }

        if ($request->order_status_id == 2) {
            OrderHistory::create([
                'order_id' => $request->order_id,
                'order_status_id' => $request->order_status_id,
                'comment' => $comment,
                'notify' => 1]);
            OrderHistory::create([
                'order_id' => $request->order_id,
                'order_status_id' => 3,
                'comment' => 'Packing',
                'notify' => 1]);
            $order->update(['order_status_id' => 3]);
            $title = $order->invoice_prefix . $order->id . ' is ready for pickup';
            PushNotificationHelper::notify($title, 'Kitchen has confirmed the order and is packing. You can go and pickup the order.', [], [$order->delivery_partner_id], 'Home', 3);

        } else {
            OrderHistory::create([
                'order_id' => $request->order_id,
                'order_status_id' => $request->order_status_id,
                'comment' => $comment,
                'notify' => 1]);
        }
        $order = Order::with(['histories' => function ($query) use ($request) {
            $query->with('status')->where('order_status_id', $request->order_status_id)->first();
        }])->where('id', $request->order_id)->first();
        $statusname = ($order->delivery_type == 0 ? $order->histories[0]->status->name : $order->histories[0]->status->name2);
        $title = $order->invoice_prefix . $order->id . ' : ' . $statusname;
        if ($order->delivery_type == 0 && $order->order_status_id == 4) {
            $message = 'Your order is ready for pickup. You can track your order from the app';
        } elseif ($order->order_status_id == 5) {
            $message = 'Your order has been ' . $comment . '. You can rate your order from the app';
        } else {
            $message = 'Your order has been ' . $comment . '. You can track your order from the app';
        }

        $status = PushNotificationHelper::notify($title, $message, ['orderId' => $order->id], [$order->customer_id], 'OrderDetail', 1);

        /* file_put_contents('updateOrderStatus.txt', "");
        error_log(json_encode([

        'title'=>$title,
        'user_id'=>$order->customer_id,
        'user_type'=>1,
        'parameter'=>$order->id,
        'route'=>'OrderDetail',
        'status'=>$request->order_status_id,
        'message'=>'Your order has been '. $comment .' you can track your order from the app'
        ]), 3, 'updateOrderStatus.txt');   */
        $PushNotification = Notification::create([
            'title' => $title,
            'user_id' => $order->customer_id,
            'user_type' => 1,
            'parameter' => $order->id,
            'route' => 'OrderDetail',
            'status' => $request->order_status_id,
            'message' => $message,
        ]);

        SmsHelper::send($order->phone, 'Your order #' . $order->invoice_prefix . $order->id . ' has been ' . $comment . '. You can track your order from the app.');
        Mail::to($order->email, $order->name)->send(new OrderStatusMail($order));
        return response()->json(['status' => true], 201);
    }
    public function salesInfo(Request $request)
    {
        $kitchenStatus = Kitchen::where('id', $request->user('api-kitchen')->id)->first();
        $totalOrders = Order::where('kitchen_id', $request->user('api-kitchen')->id)->count();
        $todayOrders = Order::where('kitchen_id', $request->user('api-kitchen')->id)->whereDate('created_at', '=', Carbon::today()->toDateString())->count();
        $totalIncome = Order::where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', 5)->sum('total');
        $todayIncome = Order::where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', 5)->whereDate('created_at', '=', Carbon::today()->toDateString())->sum('total');
        $salesInfo = [
            'today_income' => $todayIncome,
            'today_orders' => $todayOrders,
            'total_income' => $totalIncome,
            'total_orders' => $totalOrders,
        ];
        return response()->json(['sales' => $salesInfo, 'status' => $kitchenStatus->receive_order]);
    }
    public function getAllCategories()
    {
        $categories = FoodCategory::where('status', 1)->orderBy('sort_order')->get();
        $allCategories = [];
        foreach ($categories as $category) {
            $allCategories[] = [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }
        return response()->json(['categories' => $allCategories]);
    }
    public function getMenu(Request $request)
    {
        $start_date = date('Y-m-d');
        $todayFoods = KitchenFood::with('kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->whereDate('created_at', $start_date)->get();
        $allMenu = [];
        $todayMenu = [];
        foreach ($todayFoods as $kitchenFood) {
            $todayMenu[] = [
                'id' => $kitchenFood->id,
                'name' => $kitchenFood->name,
                'description' => $kitchenFood->description,
                'recipe' => $kitchenFood->recipe_details,
                'status' => $kitchenFood->status,
                'price' => $kitchenFood->price,
                'quantity' => $kitchenFood->quantity,
                'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
            ];
        }
        $allFoods = KitchenFood::with('kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->whereDate('created_at', '<>', $start_date)->get();
        foreach ($allFoods as $kitchenFood) {
            $allMenu[] = [
                'id' => $kitchenFood->id,
                'name' => $kitchenFood->name,
                'description' => $kitchenFood->description,
                'recipe' => $kitchenFood->recipe_details,
                'status' => $kitchenFood->status,
                'price' => $kitchenFood->price,
                'quantity' => $kitchenFood->quantity,
                'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
            ];
        }
        return response()->json(['menu' => $allMenu, 'todayMenu' => $todayMenu], 200);
    }

    public function getAllMenu(Request $request)
    {
        $allMenu = [];
        $allFoods = KitchenFood::with('kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->get();
        if ($allFoods->count()) {
            foreach ($allFoods as $kitchenFood) {
                $allMenu[] = [
                    'id' => $kitchenFood->id,
                    'name' => $kitchenFood->name,
                    'description' => $kitchenFood->description,
                    'recipe' => $kitchenFood->recipe_details,
                    'availableTime' => $kitchenFood->available_time,
                    'status' => $kitchenFood->status,
                    'price' => $kitchenFood->price,
                    'quantity' => $kitchenFood->quantity,
                    'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
                ];
            }
        }
        return response()->json(['menu' => $allMenu], 200);
    }

    public function addMenu(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'recipe_details' => 'required',
            'available_time' => 'required',
            'quantity' => 'required',
        ]);
        file_put_contents('menu.txt', "");
        error_log(json_encode($request->all()), 3, 'menu.txt');
        if (!empty($request->file('featuredImage'))) {
            $kitchenFood = KitchenFood::create([
                'kitchen_id' => $request->user('api-kitchen')->id,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'recipe_details' => $request->recipe_details,
                'available_time' => $request->available_time,
                'veg_status' => $request->veg_status,
                'quantity' => $request->quantity,
            ]);
            $foodCategory = json_decode($request->food_category);
            foreach ($foodCategory as $value) {
                $kitchenFood->categories()->create([
                    'food_category_id' => $value,
                ]);
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('featuredImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen_food/' . $kitchenFood->id . '/gallery')
                ->upload();
            $kitchenFood->attachMedia($media, ['gallery']);
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Please select an Image'], 401);
        }
    }
    public function updateMenu(Request $request)
    {
        file_put_contents('updateMenu.txt', '');
        error_log(json_encode($request->all()), 3, 'updateMenu.txt');
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'recipe_details' => 'required',
            'available_time' => 'required',
            'quantity' => 'required',
        ]);
        $kitchenFood = KitchenFood::with('categories')->where('id', $request->kitchen_food_id)->first();
        $featured = $kitchenFood->getMedia('gallery')->first();
        $kitchenFood->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'recipe_details' => $request->recipe_details,
            'available_time' => $request->available_time,
            'veg_status' => $request->veg_status,
            'quantity' => $request->quantity,
        ]);
        $kitchenFood->categories()->delete();
        $foodCategory = json_decode($request->food_category);
        foreach ($foodCategory as $value) {
            $kitchenFood->categories()->create([
                'food_category_id' => $value,
            ]);
        }
        if (!empty($request->file('featuredImage'))) {
            $old_image = Media::whereId($featured->id)->first();
            if ($old_image) {
                $old_image->delete();
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('featuredImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen_food/' . $kitchenFood->id . '/gallery')
                ->upload();
            $kitchenFood->attachMedia($media, ['gallery']);
        }
        return response()->json(['status' => 'success'], 200);
    }
    public function editMenu(Request $request)
    {
        $kitchenFood = KitchenFood::with('categories.category')->where('id', $request->kitchen_food_id)->first();
        $categories = [];
        $categoriesName = [];
        foreach ($kitchenFood->categories as $value) {
            //  $categories[]=[
            //       'food_category_id' => $value->food_category_id

            //      ];
            $categories[] = $value->food_category_id;
            $categoriesName[] = $value->category->name;
        }
        $food = [
            'name' => $kitchenFood->name,
            'price' => $kitchenFood->price,
            'description' => $kitchenFood->description,
            'recipe_details' => $kitchenFood->recipe_details,
            'available_time' => $kitchenFood->available_time,
            'veg_status' => $kitchenFood->veg_status,
            'quantity' => $kitchenFood->quantity,
            'categories' => $categories,
            'categoriesName' => $categoriesName,
            'featuredImage' => $kitchenFood->getMedia('gallery')->first()->getUrl(),
        ];

        return response()->json(['kitchenFood' => $food], 200);

    }
    public function RepostMenu(Request $request)
    {
        file_put_contents('menu.txt', "");
        error_log(json_encode($request->all()), 3, 'menu.txt');
        $this->validate($request, [

            'price' => 'required',
            'available_time' => 'required',
            'quantity' => 'required',
        ]);
        $food = KitchenFood::with('categories')->where('id', $request->kitchen_food_id)->first();

        $kitchenFood = KitchenFood::create([

            'kitchen_id' => $request->user('api-kitchen')->id,
            'name' => $food->name,
            'price' => $request->price,
            'description' => $food->description,
            'recipe_details' => $food->recipe_details,
            'available_time' => $request->available_time,
            'veg_status' => $request->veg_status,
            'quantity' => $request->quantity,
        ]);
        $foodCategory = $food->categories;

        foreach ($foodCategory as $value) {
            $kitchenFood->categories()->create([
                'food_category_id' => $value->food_category_id,
            ]);
        }

        //$img=$food->getMedia('gallery')->first()->getUrl();
        $time = time();
        $filename = 'CHEF_' . $time;
        $media = $food->getMedia('gallery')->first();
        $newMedia = $media->copyTo('kitchen_food/' . $kitchenFood->id . '/gallery', $filename);

        $kitchenFood->attachMedia($newMedia, ['gallery']);
        // $kitchenFood->syncMedia($media, ['gallery']);

        $kitchenFoods = KitchenFood::with('kitchen')->where('kitchen_id', $request->user('api-kitchen')->id)->get();
        $allMenu = [];
        foreach ($kitchenFoods as $kitchenFood) {
            $allMenu[] = [
                'id' => $kitchenFood->id,
                'name' => $kitchenFood->name,
                'description' => $kitchenFood->description,
                'recipe' => $kitchenFood->recipe_details,
                'status' => $kitchenFood->status,
                'price' => $kitchenFood->price,
                'quantity' => $kitchenFood->quantity,
                'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
            ];
        }
        return response()->json(['menu' => $allMenu], 200);

    }
    public function updateMenuStatus(Request $request)
    {

        $kitchenFood = KitchenFood::where('id', $request->kitchen_food_id)->first();

        if ($kitchenFood->status == 1) {
            $kitchenFood->update(['status' => 0]);
        } else {
            $kitchenFood->update(['status' => 1]);
        }

        return response()->json(['status' => $kitchenFood->status], 201);
    }
    public function imageUpload(Request $request)
    {
        file_put_contents('imageUpload.txt', "");
        error_log(json_encode($request->all()), 3, 'imageUpload.txt');
        $id = 1;
        if (!empty($request->file('featured_image'))) {

            $filename = 'featured';
            $media = MediaUploader::fromSource($request->file('featured_image'))
                ->useFilename($filename)
                ->toDirectory('testFeatured/' . $id)
                ->upload();
            if ($media) {
                return response()->json(['status' => 'success', 'image' => $media], 201);
            }

        } else {
            return response()->json(['status' => 'failed'], 401);
        }
    }
    public function getInformation(Request $request)
    {

        $information = Information::where('id', $request->info_id)->where('status', 1)->first();
        return response()->json(['information' => $information], 200);
    }

    public function getFaq()
    {
        $faqs = Faq::where('status', 1)->where('type', 1)->orderBy('sort_order')->get();
        $allfaq = [];

        foreach ($faqs as $faq) {
            $allfaq[] = [
                'id' => $faq->id,
                'title' => $faq->question,
                'content' => $faq->answer];

        }
        return response()->json(['faq' => $allfaq], 200);
    }

    public function getNotifications(Request $request)
    {
        $kitchen_id = $request->user('api-kitchen')->id;
        $notification = Notification::where('user_id', $kitchen_id)->where('user_type', 2)->where('read_status', 0)->get();
        Notification::where('user_id', $kitchen_id)->where('user_type', 2)->update(['read_status' => 1]);
        return response()->json([
            'notification' => $notification,
        ], 200);
    }
}
