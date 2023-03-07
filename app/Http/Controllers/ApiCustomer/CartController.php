<?php

namespace App\Http\Controllers\ApiCustomer;

use App\Http\Controllers\Controller;
use App\Model\Kitchen;
use App\Model\KitchenFood;
use App\Model\Order;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $customerId;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('checkout.cart');
    }

    public function create()
    {

        dd(Cart::content());

    }

    public function store(Request $request)
    {
        // print_r($request->all());
        /*file_put_contents('cart.txt','');
        error_log(json_encode($request->all()),3,'cart.txt');*/
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        if (empty($request->cart)) {
            Cart::restore($request->user('api-customer')->id);
            $cart = Cart::content();
            $price = 0;
            $food = KitchenFood::with('kitchen')->where('id', $request->food_id)->where('status', 1)->first();
            $quantity = ($request->quantity ? $request->quantity : 1);
            if ($quantity > $food->quantity) {
                return response()->json(['error' => 'This quantity is not available']);
            } else {
                $price = $food->price;
                $cartItem = Cart::add(['id' => $food->id, 'name' => $food->name, 'qty' => $quantity, 'price' => $price, 'weight' => 0, 'options' => ['currentQty' => $food->quantity, 'kitchen_id' => $food->kitchen_id]])
                    ->associate($food);
                $cart = Cart::content();
                $cart_count = count(Cart::content());
                Cart::store($request->user('api-customer')->id);
                if (!empty($cartItem)) {
                    return response()->json([
                        'message' => 'Food added to cart.',
                        'cartCount' => $cart_count,
                        'cartTotal' => Cart::total(),
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Something went wrong. Please try again',
                    ]);
                }
            }
        }

    }

    public function updateQuantity(Request $request)
    {
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $kitchenArray = [];
        $kitchenFoods = [];
        $partnerAvailable = false;
        $pickupAvailable = false;
        if ($request->user('api-customer')) {
            Cart::restore($request->user('api-customer')->id);
            $carts = Cart::content();
            $currentRow = Cart::get($request->rowId);
            $food = kitchenFood::whereId($currentRow->id)->first();
            if ($request->quantity > $food->quantity) {
                Cart::store($request->user('api-customer')->id);
                return response()->json(['message' => 'This Quantity Not Available'], 422);
            } else {
                Cart::update($request->rowId, ['qty' => $request->quantity]);
                Cart::store($request->user('api-customer')->id);
            }

            Cart::restore($request->user('api-customer')->id);
            $carts = Cart::content();
            $cart_count = count(Cart::content());
            $cart_total = Cart::total();
            $cartDetails = [];
            $kitchen = '';
            Cart::store($request->user('api-customer')->id);
            if ($cart_count) {
                $partnerFoodAvailableTime = [];
                $foodAvailableTime = [];
                $maxTime = 0;
                $foodTimings = [];
                foreach ($carts as $row) {
                    // $maxTime = $row->model->available_time > $maxTime ?
                    $foodTimings[$row->id] = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse(strtotime($row->model->available_time)), 'Asia/Kolkata');
                }
                $maxAvailableTime = max($foodTimings);
                $minAvailabelTime = min($foodTimings);
                $foodTimeDifference = $maxAvailableTime->diffInMinutes($minAvailabelTime);

                foreach ($carts as $key => $cart) {
                    // return response()->json($key);
                    $row = $cart;
                    $food = $kitchenFoods[] = KitchenFood::with('kitchen')->where('status', 1)->whereId($cart->id)->first();
                    if (!empty($food)) {
                        $kitchen = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])
                            ->havingRaw('distance <= 5')
                            ->whereRaw('status=1')->whereRaw('verification_status=1')
                            ->whereRaw('id= ' . $food->kitchen_id)
                            ->orderBy('distance')
                            ->first();
                        if (!empty($kitchen)) {
                            $row->food_status = 1;
                            $row->currentQuantity = $food->quantity;
                            $row->deliveryStatus = 1;
                            if ($cart->qty > $food->quantity) {
                                $row->message = 'Quantity not available right now';
                                $row->statusId = 2;
                            } elseif (($cart_count > 1 && $foodTimings[$row->id] > Carbon::now()->addMinutes(30) && $foodTimeDifference > 30) || ($cart_count > 1 && $foodTimeDifference > 30 && $minAvailabelTime->diffInMinutes($foodTimings[$row->id]) == $foodTimeDifference)) {
                                $row->message = 'Please remove this item to proceed';
                                $row->statusId = 2;
                                /*}elseif(($cart_count>1 && $foodTimings[$row->id] > Carbon::now()->addMinutes(30)) || ($cart_count>1 && $foodTimeDifference > 30)){
                            $row->message='Please remove this item to proceed';
                            $row->statusId=2;*/
                            }
                        } else {
                            $row->food_status = 1;
                            $row->currentQuantity = $food->quantity;
                            $row->deliveryStatus = 0;
                            $row->statusId = 2;
                            $row->message = 'Product not available at this location';
                        }

                    } else {
                        $row->food_status = 0;
                        $row->currentQuantity = 0;
                        $row->deliveryStatus = 0;
                        $row->statusId = 2;
                        $row->message = 'Product not available';
                    }

                    $cartDetails[] = $row;
                    // $kitchen_id=$food->kitchen_id;
                    if (!empty($food)) {
                        $kitchenArray = $food->kitchen;
                    }

                    $availableTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse(strtotime($row->model->available_time)), 'Asia/Kolkata');
                    // return response()->json( Carbon::now());
                    if ($availableTime >= Carbon::now()) {
                        $partnerFoodAvailableTime[$row->rowId] = $availableTime;
                    }
                    $foodAvailableTime[$row->rowId] = Carbon::parse(strtotime($row->model->available_time));
                }
                if (count($partnerFoodAvailableTime)) {
                    $maxAvailableTime = max($partnerFoodAvailableTime);
                    $minAvailabelTime = min($partnerFoodAvailableTime);
                    $timeDifference = $maxAvailableTime->diffInMinutes($minAvailabelTime);
                    $partnerAvailable = $minAvailabelTime->diffInMinutes(Carbon::now()) > 30 ? false : true;
                } else {
                    $partnerAvailable = true;
                }
                if (count($foodAvailableTime)) {
                    $maxAvailableTime = max($foodAvailableTime);
                    $minAvailabelTime = min($foodAvailableTime);
                    $pickupAvailable = $maxAvailableTime->diffInMinutes($minAvailabelTime) > 30 ? false : true;
                } else {
                    $pickupAvailable = true;
                }
            }
            return response()->json(['message' => 'Item quantity updated successfully.', 'cartCount' => $cart_count, 'cart' => $cartDetails, 'cartTotal' => $cart_total, 'kitchen' => $kitchenArray, 'partnerAvailable' => $partnerAvailable, 'pickupAvailable' => $pickupAvailable]);
        }
    }

    public function updateItem(Request $request)
    {

        Cart::restore($request->user('api-customer')->id);
        $cartSubTotal = Cart::subtotal();
        $cart = Cart::content();

        $cartCount = count(Cart::content());

        $currentRow = Cart::get($request->rowId);
        $food = kitchenFood::whereId($currentRow->id)->first();

        if ($request->quantity > $food->quantity) {

            Cart::store($request->user('api-customer')->id);

            return response()->json(['message' => 'This Quantity Not Available'], 422);

        } else {

            Cart::update($request->rowId, [

                'options' => ['additional' => $request->additional, 'note' => $request->note]]);

            Cart::store($request->user('api-customer')->id);

            return response()->json(['message' => 'Item updated successfully.', 'cartCount' => $cartCount, 'cart' => Cart::content(), 'cartTotal' => Cart::total()]);

        }

    }

    public function getCartDetails(Request $request)
    {
        // Check Cart
        $currentTime = Carbon::now()->Format('Y-m-d H:i:s');
        $startTime = Carbon::now()->subMinutes(15)->Format('Y-m-d H:i:s');
        $orders = Order::with('food')->whereCustomerId($request->user('api-customer')->id)->where('order_status_id', 0)->WhereBetween('created_at', [$startTime, $currentTime])->get();
        if ($orders->count()) {
            foreach ($orders as $order) {
                foreach ($order->food as $food) {
                    KitchenFood::find($food->kitchen_food_id)->increment('quantity', $food->quantity);
                }
                $order->update(['order_status_id' => 10]);
                $order->histories()->create([
                    'order_status_id' => 10,
                    'notify' => 0,
                    'comment' => 'Payment Failed',
                ]);
            }
        }
        // Check Cart
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $kitchenArray = [];
        $kitchenFoods = [];
        $partnerAvailable = false;
        $pickupAvailable = false;
        if ($request->user('api-customer')) {
            Cart::restore($request->user('api-customer')->id);
            $carts = Cart::content();
            $cart_count = count(Cart::content());
            $cart_total = Cart::total();
            $cartDetails = [];
            $kitchen = '';
            Cart::store($request->user('api-customer')->id);
            if ($cart_count) {
                $partnerFoodAvailableTime = [];
                $foodAvailableTime = [];
                $maxTime = 0;
                $foodTimings = [];
                foreach ($carts as $row) {
                    // $maxTime = $row->model->available_time > $maxTime ?
                    $foodTimings[$row->id] = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse(strtotime($row->model->available_time)), 'Asia/Kolkata');
                }
                $maxAvailableTime = max($foodTimings);
                $minAvailabelTime = min($foodTimings);
                $foodTimeDifference = $maxAvailableTime->diffInMinutes($minAvailabelTime);

                foreach ($carts as $key => $cart) {
                    // return response()->json($key);
                    $row = $cart;
                    $food = $kitchenFoods[] = KitchenFood::with('kitchen')->where('status', 1)->whereId($cart->id)->first();
                    if (!empty($food)) {
                        $kitchen = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])
                            ->havingRaw('distance <= 5')
                            ->whereRaw('status=1')->whereRaw('verification_status=1')
                            ->whereRaw('id= ' . $food->kitchen_id)
                            ->orderBy('distance')
                            ->first();
                        if (!empty($kitchen)) {
                            $row->food_status = 1;
                            $row->currentQuantity = $food->quantity;
                            $row->deliveryStatus = 1;
                            if ($cart->qty > $food->quantity) {
                                $row->message = 'Quantity not available right now';
                                $row->statusId = 2;
                            } elseif (($cart_count > 1 && $foodTimings[$row->id] > Carbon::now()->addMinutes(30) && $foodTimeDifference > 30) || ($cart_count > 1 && $foodTimeDifference > 30 && $minAvailabelTime->diffInMinutes($foodTimings[$row->id]) == $foodTimeDifference)) {
                                $row->message = 'Please remove this item to proceed';
                                $row->statusId = 2;
                                /*}elseif(($cart_count>1 && $foodTimings[$row->id] > Carbon::now()->addMinutes(30)) || ($cart_count>1 && $foodTimeDifference > 30)){
                            $row->message='Please remove this item to proceed';
                            $row->statusId=2;*/
                            }
                        } else {
                            $row->food_status = 1;
                            $row->currentQuantity = $food->quantity;
                            $row->deliveryStatus = 0;
                            $row->statusId = 2;
                            $row->message = 'Product not available at this location';
                        }

                    } else {
                        $row->food_status = 0;
                        $row->currentQuantity = 0;
                        $row->deliveryStatus = 0;
                        $row->statusId = 2;
                        $row->message = 'Product not available';
                    }

                    $cartDetails[] = $row;
                    // $kitchen_id=$food->kitchen_id;
                    if (!empty($food)) {
                        $kitchenArray = $food->kitchen;
                    }

                    $availableTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse(strtotime($row->model->available_time)), 'Asia/Kolkata');
                    // return response()->json( Carbon::now());
                    if ($availableTime >= Carbon::now()) {
                        $partnerFoodAvailableTime[$row->rowId] = $availableTime;
                    }
                    $foodAvailableTime[$row->rowId] = Carbon::parse(strtotime($row->model->available_time));
                }
                if (count($partnerFoodAvailableTime)) {
                    $maxAvailableTime = max($partnerFoodAvailableTime);
                    $minAvailabelTime = min($partnerFoodAvailableTime);
                    $timeDifference = $maxAvailableTime->diffInMinutes($minAvailabelTime);
                    $partnerAvailable = $minAvailabelTime->diffInMinutes(Carbon::now()) > 30 ? false : true;
                } else {
                    $partnerAvailable = true;
                }
                if (count($foodAvailableTime)) {
                    $maxAvailableTime = max($foodAvailableTime);
                    $minAvailabelTime = min($foodAvailableTime);
                    $pickupAvailable = $maxAvailableTime->diffInMinutes($minAvailabelTime) > 30 ? false : true;
                } else {
                    $pickupAvailable = true;
                }
            }
            return response()->json(['cart_count' => $cart_count, 'cart' => $cartDetails, 'cart_total' => $cart_total, 'kitchen' => $kitchenArray, 'partnerAvailable' => $partnerAvailable, 'pickupAvailable' => $pickupAvailable]);
        }
    }

    public function getMenuDeatail(Request $request)
    {
        Cart::restore($request->user('api-customer')->id);
        $carts = Cart::content()->where('id', $request->food_id)->first();
        $cartContents = Cart::content()->first();
        Cart::store($request->user('api-customer')->id);
        //dd($carts->toArray());

        $kitchenFood = KitchenFood::with('kitchen')->where('id', $request->food_id)->first();
        $food = [];
        $food = [
            'id' => $kitchenFood->id,
            'name' => $kitchenFood->name,
            'kitchen_id' => $kitchenFood->kitchen->id,
            'kitchen_name' => $kitchenFood->kitchen->name,
            'longitude' => $kitchenFood->kitchen->longitude,
            'latitude' => $kitchenFood->kitchen->latitude,
            'kitchen' => $kitchenFood->kitchen,
            'description' => $kitchenFood->description,
            'recipe' => $kitchenFood->recipe_details,
            'veg_status' => $kitchenFood->veg_status,
            'price' => $kitchenFood->price,
            'quantity' => $kitchenFood->quantity,
            'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
            'cartQuantity' => !empty($carts->options) ? $carts->qty : 0,
            'cartCount' => count(Cart::content()),
            'rowId' => !empty($carts) ? $carts->rowId : '',
            'note' => !empty($carts->options) ? $carts->options->note : '',
            'additional' => !empty($carts->options) ? $carts->options->additional : '',
            'subTotal' => Cart::total(),

        ];

        $kitchen = Kitchen::whereId($kitchenFood->kitchen->id)->first();
        $cartDetails = [
            'cartQuantity' => !empty($carts->options) ? $carts->qty : 0,
            'cartCount' => count(Cart::content()),
            'rowId' => !empty($carts) ? $carts->rowId : ''];
        return response()->json(['kitchen_menu' => $food, 'cartDetails' => $cartDetails, 'kitchen' => $kitchen], 200);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        Cart::restore($request->user('api-customer')->id);
        $cart = Cart::content();

        Cart::remove($request->rowId);

        $cart = Cart::content();
        $cartCount = count(Cart::content());

        Cart::store($request->user('api-customer')->id);
        return response()->json(['message' => 'Item Removed successfully.', 'cartCount' => $cartCount, 'cart' => $cart]);

    }

    public function clearCart(Request $request)
    {

        Cart::restore($request->user('api-customer')->id);
        Cart::destroy();
        return response()->json(['message' => 'Cart cleared']);
    }

    public function checkAvailable(Request $request)
    {
        $carts = $request->cart;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $cartDetails = [];
        if (!empty($carts)) {
            foreach ($carts as $cart) {
                $row = $cart;

                $food = KitchenFood::with('kitchen')->where('id', $cart['id'])->where('status', 1)->first();

                if (!empty($food)) {
                    $kitchen = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude])
                        ->havingRaw('distance <= 5')
                        ->whereRaw('status=1')->whereRaw('verification_status=1')
                        ->whereRaw('id= ' . $food->kitchen_id)
                        ->orderBy('distance')
                        ->first();
                    if (!empty($kitchen)) {
                        $row['food_status'] = 1;
                        $row['currentQuantity'] = $food->quantity;
                        $row['deliveryStatus'] = 1;

                    } else {
                        $row['food_status'] = 1;
                        $row['currentQuantity'] = $food->quantity;
                        $row['deliveryStatus'] = 0;
                    }
                } else {
                    $row['food_status'] = 0;
                    $row['currentQuantity'] = 0;
                    $row['deliveryStatus'] = 0;
                }
                $cartDetails[] = $row;

            }
        }
        return response()->json(['message' => 'Success', 'cart' => $cartDetails]);
    }
    public function storeCart(Request $request)
    {
        file_put_contents('storeCart.txt', "");
        error_log(json_encode($request->all()), 3, 'storeCart.txt');
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $cartDetails = [];
        Cart::restore($request->user('api-customer')->id);
        Cart::destroy();
        if (!empty($request->cart)) {
            $carts = $request->cart;
            foreach ($carts as $cart) {
                $row = $cart;
                $food = KitchenFood::where('status', 1)->whereId($cart['id'])->first();
                $cartItem = Cart::add([
                    'id' => $cart['id'],
                    'name' => $cart['name'],
                    'qty' => $cart['qty'],
                    'price' => $cart['price'], 'weight' => 0,
                    'options' => ['currentQty' => $food->quantity, 'kichen_id' => $food->kichen_id]])
                    ->associate($food);

            }

        }
        $cart_total = Cart::subtotal();
        $carts = Cart::content();
        $cartCount = count(Cart::content());
        Cart::store($request->user('api-customer')->id);
        if (!empty($cartItem)) {
            return response()->json([
                'success' => ['message' => 'Product added to cart.', 'cartCount' => $cartCount, 'cartTotal' => $cart_total, 'cart' => $carts],
            ]);
        } else {
            return response()->json([
                'error' => 'Something went wrong. Please try again',
            ]);
        }
    }

}
