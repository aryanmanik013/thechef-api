<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CouponHistory;
use App\Model\Kitchen;
use App\Model\Order;
use App\Model\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Report')) {
            abort(403);
        }
        $currentDay = Carbon::now()->format('Y-m-d');

        if (Auth::guard('admin')->user()->id == 1) {

            $orders = Order::where('order_status_id', 5)->where(function ($query) use ($request) {

                if ($request->filter == 'today') {
                    $query->whereDate('created_at', date('Y-m-d'));
                } else if ($request->filter == 'week') {
                    $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                } else if ($request->filter == 'month') {
                    $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                } else if ($request->filter == 'year') {
                    $query->whereYear('created_at', date('Y'));
                }
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');

        } else {
            $orders = Order::with(['kitchen'])->where('order_status_id', 4)->where(function ($query) use ($request) {

                $query->whereHas('kitchen', function ($query) {

                    $query->Where('country_id', Auth::guard('admin')->user()->country_id);

                });
                if ($request->filter == 'today') {
                    $query->whereDate('created_at', date('Y-m-d'));
                } else if ($request->filter == 'week') {
                    $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                } else if ($request->filter == 'month') {
                    $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                } else if ($request->filter == 'year') {
                    $query->whereYear('created_at', date('Y'));
                }
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('country_id', Auth::guard('admin')->user()->country_id)->where('status', 1)->get()->pluck('name', 'id');
        }

        $orderSatatus = OrderStatus::whereIn('id', [5, 6])->get()->pluck('name', 'id');

        return view('admin.report.report')->with(['reports' => $orders, 'kitchens' => $kitchen, 'orderSatatus' => $orderSatatus]);

    }
    public function reportFilter(Request $request)
    {

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Report')) {
            abort(403);
        }
        $currentDay = Carbon::now()->format('Y-m-d');
        $orderStatus = 4;
        if (Auth::guard('admin')->user()->id == 1) {
            if (!empty($request->order_status_id)) {
                $orderStatus = $request->order_status_id;
            }

            $from = isset($request->from) ? Carbon::parse($request->from)->Format('Y-m-d') : date('Y-m-01');
            $to = isset($request->to) ? Carbon::parse($request->to)->Format('Y-m-d') : date('Y-m-t');

            $orders = Order::where('order_status_id', $orderStatus)->where(function ($query) use ($request, $to, $from) {

                if (isset($request->kitchen)) {
                    $query->where('kitchen_id', $request->kitchen);
                }

                if (isset($request->from) || isset($request->to)) {
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
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');
        } else {

            if (!empty($request->order_status_id)) {
                $orderStatus = $request->order_status_id;
            }

            $from = isset($request->from) ? Carbon::parse($request->from)->Format('Y-m-d') : date('Y-m-01');
            $to = isset($request->to) ? Carbon::parse($request->to)->Format('Y-m-d') : date('Y-m-t');

            $orders = Order::where('order_status_id', $orderStatus)->where(function ($query) use ($request, $to, $from) {

                $query->whereHas('kitchen', function ($query) {

                    $query->Where('country_id', Auth::guard('admin')->user()->country_id);

                });

                if (isset($request->kitchen)) {
                    $query->where('kitchen_id', $request->kitchen);
                }

                if (isset($request->from) || isset($request->to)) {
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
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('country_id', Auth::guard('admin')->user()->country_id)->where('status', 1)->get()->pluck('name', 'id');

        }

        $orderSatatus = OrderStatus::whereIn('id', [5, 6])->get()->pluck('name', 'id');

        return view('admin.report.report')->with(['reports' => $orders, 'kitchens' => $kitchen, 'orderSatatus' => $orderSatatus]);

    }

    public function cancelledReport(Request $request)
    {

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Report')) {
            abort(403);
        }
        $currentDay = Carbon::now()->format('Y-m-d');

        if (Auth::guard('admin')->user()->id == 1) {

            $orders = Order::where('order_status_id', 6)->where(function ($query) use ($request) {

                if ($request->filter == 'today') {
                    $query->whereDate('created_at', date('Y-m-d'));
                } else if ($request->filter == 'week') {
                    $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                } else if ($request->filter == 'month') {
                    $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                } else if ($request->filter == 'year') {
                    $query->whereYear('created_at', date('Y'));
                }
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');

        } else {
            $orders = Order::with(['kitchen'])->where('order_status_id', 4)->where(function ($query) use ($request) {

                $query->whereHas('kitchen', function ($query) {

                    $query->Where('country_id', Auth::guard('admin')->user()->country_id);

                });
                if ($request->filter == 'today') {
                    $query->whereDate('created_at', date('Y-m-d'));
                } else if ($request->filter == 'week') {
                    $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                } else if ($request->filter == 'month') {
                    $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                } else if ($request->filter == 'year') {
                    $query->whereYear('created_at', date('Y'));
                }
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('country_id', Auth::guard('admin')->user()->country_id)->where('status', 1)->get()->pluck('name', 'id');
        }

        $orderSatatus = OrderStatus::whereIn('id', [5, 6])->get()->pluck('name', 'id');

        return view('admin.report.cancelled_report')->with(['reports' => $orders, 'kitchens' => $kitchen, 'orderSatatus' => $orderSatatus]);

    }
    public function cancelledReportFilter(Request $request)
    {

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Report')) {
            abort(403);
        }
        $currentDay = Carbon::now()->format('Y-m-d');
        $orderStatus = 6;
        if (Auth::guard('admin')->user()->id == 1) {
            if (!empty($request->order_status_id)) {
                $orderStatus = $request->order_status_id;
            }

            $from = isset($request->from) ? Carbon::parse($request->from)->Format('Y-m-d') : date('Y-m-01');
            $to = isset($request->to) ? Carbon::parse($request->to)->Format('Y-m-d') : date('Y-m-t');

            $orders = Order::where('order_status_id', $orderStatus)->where(function ($query) use ($request, $to, $from) {

                if (isset($request->kitchen)) {
                    $query->where('kitchen_id', $request->kitchen);
                }

                if (isset($request->from) || isset($request->to)) {
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
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');
        } else {

            if (!empty($request->order_status_id)) {
                $orderStatus = $request->order_status_id;
            }

            $from = isset($request->from) ? Carbon::parse($request->from)->Format('Y-m-d') : date('Y-m-01');
            $to = isset($request->to) ? Carbon::parse($request->to)->Format('Y-m-d') : date('Y-m-t');

            $orders = Order::where('order_status_id', $orderStatus)->where(function ($query) use ($request, $to, $from) {

                $query->whereHas('kitchen', function ($query) {

                    $query->Where('country_id', Auth::guard('admin')->user()->country_id);

                });

                if (isset($request->kitchen)) {
                    $query->where('kitchen_id', $request->kitchen);
                }

                if (isset($request->from) || isset($request->to)) {
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
            })->orderBy('id', 'DESC')->get();
            $kitchen = Kitchen::where('country_id', Auth::guard('admin')->user()->country_id)->where('status', 1)->get()->pluck('name', 'id');

        }

        $orderSatatus = OrderStatus::whereIn('id', [5, 6])->get()->pluck('name', 'id');

        return view('admin.report.cancelled_report')->with(['reports' => $orders, 'kitchens' => $kitchen, 'orderSatatus' => $orderSatatus]);

    }

    public function couponReport(Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Report')) {
            abort(403);
        }

        $CouponHistory = CouponHistory::with('coupon', 'order')
            ->where(function ($query) use ($request) {
                if ($request->filter == 'today') {
                    $query->whereDate('created_at', date('Y-m-d'));
                } else if ($request->filter == 'week') {
                    $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                } else if ($request->filter == 'month') {
                    $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                } else if ($request->filter == 'year') {
                    $query->whereYear('created_at', date('Y'));
                }

            })->get()->groupBy(function ($item) {
            return $item->coupon->name;
        });

        $couponReport = [];
        $totalOrder = 0;
        $totalDiscount = 0;
        foreach ($CouponHistory as $key => $coupon) {

            $couponReport[] = [
                'name' => $key,
                'count' => count($coupon),
                'discount' => $coupon->sum('amount'),
            ];
            $totalOrder += count($coupon);
            $totalDiscount += $coupon->sum('amount');
        }
        $kitchen = Kitchen::where('country_id', Auth::guard('admin')->user()->country_id)->where('status', 1)->get()->pluck('name', 'id');
        $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');

        return view('admin.report.coupon_report')->with(['reports' => $couponReport, 'totalOrder' => $totalOrder, 'totalDiscount' => $totalDiscount, 'kitchens' => $kitchen]);

    }
    public function couponReportFilter(Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Report')) {
            abort(403);
        }
        $CouponHistory = CouponHistory::with('coupon', 'order')
            ->where(function ($query) use ($request) {
                if ($request->filter == 'today') {
                    $query->whereDate('created_at', date('Y-m-d'));
                } else if ($request->filter == 'week') {
                    $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                } else if ($request->filter == 'month') {
                    $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                } else if ($request->filter == 'year') {
                    $query->whereYear('created_at', date('Y'));
                }

            })->where(function ($query) use ($request) {
            if (isset($request->kitchen)) {
                $query->whereHas('order', function ($query1) use ($request) {
                    $query1->where('kitchen_id', $request->kitchen);
                });

            }
        })->get()->groupBy(function ($item) {
            return $item->coupon->name;
        });
        $couponReport = [];
        $totalOrder = 0;
        $totalDiscount = 0;
        foreach ($CouponHistory as $key => $coupon) {

            $couponReport[] = [
                'name' => $key,
                'count' => count($coupon),
                'discount' => $coupon->sum('amount'),
                // 'created_at'=>Carbon::parse($coupon->created_at)->format('d-m-Y')
            ];
            $totalOrder += count($coupon);
            $totalDiscount += $coupon->sum('amount');
        }
        $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');

        return view('admin.report.coupon_report')->with(['reports' => $couponReport, 'kitchens' => $kitchen, 'totalDiscount' => $totalDiscount, 'totalOrder' => $totalOrder, 'kitchen_id' => $request->kitchen]);

    }

//     public function OrderDispute(Request $request)
    //     {
    //       $store_id = $request->user('api-store')->id;
    //       $orders=OrderDispute::with('order.orderStatus','reason')->where(function ($query) use ($store_id) {
    //                 if(isset($store_id)){
    //                 $query->whereHas('order', function($query1) use ($store_id){
    //                   $query1->where('store_id',$store_id);
    //                     });
    //             }
    //          })->where(function($query) use($request){
    //             if($request->filter=='today'){
    //                 $query->whereDate('created_at',date('Y-m-d'));
    //             } else if($request->filter=='week'){
    //                 $query->whereDate('created_at','>=',Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at','<=',Carbon::now()->endOfWeek()->format('Y-m-d'));
    //             } else if($request->filter=='month'){
    //                 $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
    //             }
    //             else if($request->filter=='year'){
    //                 $query->whereYear('created_at', date('Y'));
    //             }
    //         })->get();

//         $disputedOrders=[];
    //         if($orders->count()){
    //             foreach($orders as $key => $order){
    //                 // $totalProductCount=0;
    //                 // $bundleProducts='';
    //                 // $bundleProducts=$order->bundleProducts->unique('store_bundle_id');
    //                 // $totalProductCount=count($order->products)+(!empty($bundleProducts)?count($bundleProducts):0);

//                 $disputedOrders[$key] = [
    //                     'id' => $order->order->id,
    //                     'invoicePrefix' => $order->order->invoice_prefix,
    //                     'storeName' => $order->order->store_name,
    //                     'customerName' => $order->order->name,
    //                     'total' => $order->order->total,
    //                     // 'productCount' => $totalProductCount,
    //                     'statusId'=> $order->order->orderStatus->id,
    //                     'statusName' =>  $order->order->orderStatus->name,
    //                     'orderTime' =>date('d-M-Y h:i a', strtotime($order->created_at)),
    //                 ];
    //             }
    //         }
    //          return response()->json(['status'=>'success','orders'=>$disputedOrders]);

//     }
}
