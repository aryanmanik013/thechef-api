<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Model\DeliveryPartner;
use App\Model\Kitchen;
use App\Model\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kitchenList = [];
        $kitchens = Kitchen::where('approval_status', 0)->orderBy('id', 'desc')->get();
        foreach ($kitchens as $kitchen) {
            $kitchenList[] = [
                'id' => $kitchen->id,
                'message' => 'Kitchen ' . $kitchen->name . ' - Waiting For Approval',
                'date' => $kitchen->created_at,
                'type' => 1,
                'created_at' => date('d-m-y h:i', strtotime($kitchen->created_at)),
            ];
        }
        $deliveryList = [];
        $deliveries = DeliveryPartner::where('approval_status', 0)->orderBy('id', 'desc')->get();
        foreach ($deliveries as $delivery) {
            $deliveryList[] = [
                'id' => $delivery->id,
                'message' => 'Delivery Partner ' . $delivery->name . ' - Waiting For Approval',
                'date' => $delivery->created_at,
                'type' => 2,
                'created_at' => date('d-m-y h:i', strtotime($delivery->created_at)),
            ];
        }
        $mergedArray = array_merge($kitchenList, $deliveryList);
        array_multisort(array_column($mergedArray, 'date'), SORT_DESC, $mergedArray);
        return view('admin.home')->with([
            //'kitchen_count'=>Kitchen::where('status',1)->where('approval_status',1)->count(),
            'kitchen_count' => Kitchen::count(),
            'customer_count' => Customer::where('status', 1)->count(),
            'customer_count' => Customer::where('status', 1)->count(),
            'order_count' => Order::count(),
            'sales' => Order::whereIn('order_status_id', [2, 3, 4, 13])->sum('total'),
            'recent_activites' => $mergedArray,
        ]);

    }
    public function autoCompleteAjax(Request $request)
    {
        $search = $request->term;

        //$posts = Product::where('name','LIKE',"%{$search}%")->limit(5)->get();
        $posts = Kitchen::where('name', 'LIKE', "%{$search}%")->get();

        $row_set = array();
        if (!$posts->isEmpty()) {
            foreach ($posts as $post) {
                $new_row['id'] = $post->id;
                $new_row['value'] = $post->name;
                $row_set[] = $new_row; //build an array
            }
        }

        echo json_encode($row_set);
    }
}
