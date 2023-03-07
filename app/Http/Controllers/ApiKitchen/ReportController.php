<?php

namespace App\Http\Controllers\ApiKitchen;

use App\Http\Controllers\Controller;
use App\Model\CouponHistory;
use App\Model\Order;
use App\Model\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalSales = 0;
        $totalOrders = 0;
        $kitchen_id = $request->user('api-kitchen')->id;
        $start_date = isset($request->start_date) ? Carbon::parse($request->start_date)->Format('Y-m-d') : date('Y-m-d');
        $cancelReport = Order::where('order_status_id', 6)->where('kitchen_id', $kitchen_id)->whereDate('created_at', $start_date)->get();
        $cancelledOrders = Order::where('order_status_id', 6)->where('kitchen_id', $kitchen_id)->whereDate('created_at', $start_date)->count();
        $orders = Order::where('kitchen_id', $kitchen_id)->whereDate('created_at', $start_date)->get();
        $kitchenOrders = [];
        $label = ['0-4', '4-8', '8-12', '12-16', '16-20', '20-24'];
        $data = [
            $orders->whereBetween('created_at', [$start_date . ' 00:00:00', $start_date . ' 04:00:00'])->count(),
            $orders->whereBetween('created_at', [$start_date . ' 04:00:00', $start_date . ' 08:00:00'])->count(),
            $orders->whereBetween('created_at', [$start_date . ' 08:00:00', $start_date . ' 12:00:00'])->count(),
            $orders->whereBetween('created_at', [$start_date . ' 12:00:00', $start_date . ' 16:00:00'])->count(),
            $orders->whereBetween('created_at', [$start_date . ' 16:00:00', $start_date . ' 20:00:00'])->count(),
            $orders->whereBetween('created_at', [$start_date . ' 20:00:00', $start_date . ' 24:00:00'])->count(),
        ];
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
                'total' => $order->total,
                'statusId' => $order->status ? $order->status->id : 0,
                'statusName' => $order->status ? $order->status->name : 'Failed',
                'foods' => $orderFoods,
                'orderTime' => date('h:i A', strtotime($order->created_at)),
                'orderDate' => date('d F Y ', strtotime($order->created_at)),
            ];
        }
        $couponReport = CouponHistory::with('coupon', 'order', 'customer')
            ->where(function ($query) use ($kitchen_id) {
                if (isset($kitchen_id)) {
                    $query->whereHas('order', function ($query1) use ($kitchen_id) {
                        $query1->where('kitchen_id', $kitchen_id);
                    });
                }
            })->whereDate('created_at', $start_date)->get();

        $couponSales = $couponReport->sum('amount');
        $couponCount = $couponReport->count();

        $totalSales = $orders->where('order_status_id', 5)->sum('total');
        $totalOrders = $orders->count();
        $cancelledSales = $cancelReport->sum('total');
        $cancelledOrders = $cancelReport->count();
        $deliveredReport = Order::where('kitchen_id', $kitchen_id)->whereDate('created_at', $start_date)->where('order_status_id', 5)->get();
        $totalDelivered = $deliveredReport->count();
        $salesDelivered = $deliveredReport->sum('total');
        return response()->json(['orders' => $kitchenOrders, 'couponSales' => $couponSales, 'couponCount' => $couponCount, 'totalDelivered' => $totalDelivered, 'salesDelivered' => $salesDelivered, 'cancelledOrders' => $cancelledOrders, 'totalSales' => $totalSales, 'totalOrders' => $totalOrders, 'cancelledSales' => $cancelledSales, 'label' => $label, 'orderData' => $data]);
    }
    public function mapReport(Request $request)
    {

        $group_type = $request->type;
        $kitchen_id = $request->user('api-kitchen')->id;
        //$kitchen_id = 233;
        $totalSales = 0;
        $totalOrders = 0;
        $CouponAmount = 0;
        $totalDelivered = 0;
        $totalCancelled = 0;
        $couponOrderCount = 0;
        $orderDispute = [];
        $monthlyOrder = [];
        $dateArray = [];
        $kitchenOrders = [];
        $dateBetween = [];
        if ($group_type == 2) {
            // $dateBetween=[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            $weaklyOrder = Order::where('kitchen_id', $kitchen_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $kitchenOrders = [];
            foreach ($weaklyOrder as $key => $order) {
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
                    'total' => $order->total,
                    'statusId' => $order->status ? $order->status->id : 0,
                    'statusName' => $order->status ? $order->status->name : 'Failed',
                    'foods' => $orderFoods,
                    'orderTime' => date('h:i A', strtotime($order->created_at)),
                    'orderDate' => date('d F Y ', strtotime($order->created_at)),

                ];
            }
            $weaklyOrderReport = $weaklyOrder->groupBy(function ($item) {
                return $item->created_at->format('D');
            });
            $totalDelivered = $weaklyOrder->where('order_status_id', 5)->count();
            $totalCancelled = $weaklyOrder->where('order_status_id', 6)->count();
            $salesDelivered = $weaklyOrder->where('order_status_id', 5)->sum('total');
            $salesCancelled = $weaklyOrder->where('order_status_id', 6)->sum('total');
            $totalSales = 0;
            $totalOrders = 0;
            $label = [];
            $data = [];
            $label = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $data = [0, 0, 0, 0, 0, 0, 0];

            //  foreach ($weaklyOrder as $key => $weakly)
            //   {
            //       $label[]=$key;
            //       $data[]=count($weakly);

            //   }
            foreach ($weaklyOrderReport as $key => $order) {

                if ($order->where('order_status_id', 5)) {
                    // $totalSales+=$order->sum('total');

                }
                $index = array_search($key, $label);
                // $data[$index]=$order->sum('total');
                $data[$index] = count($order);
                $totalOrders += count($order);

            }
            $totalSales = $salesDelivered;
            $couponReport = CouponHistory::with('coupon', 'order', 'customer')
                ->where(function ($query) use ($kitchen_id) {
                    if (isset($kitchen_id)) {
                        $query->whereHas('order', function ($query1) use ($kitchen_id) {
                            $query1->where('kitchen_id', $kitchen_id);
                        });
                    }
                })->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

            $CouponAmount = $couponReport->sum('amount');
            $couponOrderCount = $couponReport->count();
        }
        if ($group_type == 3) {
            $monthlyOrder = Order::with('food')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('kitchen_id', $kitchen_id)->orderBy('id', 'desc')->orderBy('id', 'DESC')->get();
            $monthlyOrderReport = $monthlyOrder->groupBy(function ($item) use ($group_type) {
                return $item->created_at->format('Y-M-d');
            });
            $totalDelivered = $monthlyOrder->where('order_status_id', 5)->count();
            $totalCancelled = $monthlyOrder->where('order_status_id', 6)->count();
            $salesDelivered = $monthlyOrder->where('order_status_id', 5)->sum('total');
            $salesCancelled = $monthlyOrder->where('order_status_id', 6)->sum('total');
            //   return response()->json([$monthlyOrder]);
            $totalSales = 0;
            $totalOrders = 0;
            $firstDay = date('Y-m-01');
            $lastDay = date('Y-m-t');
            $label = [];
            for ($i = 1; $i <= date('t'); $i++) {

                $label_temp[] = date('Y') . "-" . date('M') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                $label[] = str_pad($i, 2, '0', STR_PAD_LEFT);
                $data[] = 0;
            }

            foreach ($monthlyOrderReport as $key => $order) {
                if ($order->where('order_status_id', 5)) {
                    // $totalSales+=$order->sum('total');
                }

                $totalOrders += count($order);
                $index = array_search($key, $label_temp);
                $data[$index] = count($order);
            }
            $totalSales = $salesDelivered;
            $couponReport = CouponHistory::with('coupon', 'order', 'customer')
                ->where(function ($query) use ($kitchen_id) {
                    if (isset($kitchen_id)) {
                        $query->whereHas('order', function ($query1) use ($kitchen_id) {
                            $query1->where('kitchen_id', $kitchen_id);
                        });
                    }
                })->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

            $CouponAmount = $couponReport->sum('amount');
            $couponOrderCount = $couponReport->count();

        } else if ($group_type == 4) {
            $yearlyOrder = Order::with('food')->whereYear('created_at', date('Y'))->where('kitchen_id', $kitchen_id)->orderBy('id', 'desc')->orderBy('id', 'DESC')->get();
            $totalDelivered = $yearlyOrder->where('order_status_id', 5)->count();
            $totalCancelled = $yearlyOrder->where('order_status_id', 6)->count();
            $salesDelivered = $yearlyOrder->where('order_status_id', 5)->sum('total');
            $salesCancelled = $yearlyOrder->where('order_status_id', 6)->sum('total');
            $orders = $yearlyOrder->groupBy(function ($item) use ($group_type) {
                return $item->created_at->format('M');
            });

            $label = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($orders as $key => $order) {
                if ($order->where('order_status_id', 5)) {
                    // $totalSales+=$order->sum('total');
                }
                $totalOrders += count($order);
                $index = array_search($key, $label);
                // $data[$index]=count($order);
                $data[$index] = $order->sum('total');
            }
            $totalSales = $salesDelivered;
            $couponReport = CouponHistory::with('coupon', 'order', 'customer')
                ->where(function ($query) use ($kitchen_id) {
                    if (isset($kitchen_id)) {
                        $query->whereHas('order', function ($query1) use ($kitchen_id) {
                            $query1->where('kitchen_id', $kitchen_id);
                        });
                    }
                })->whereYear('created_at', date('Y'))->get();
            $CouponAmount = $couponReport->sum('amount');
            $couponOrderCount = $couponReport->count();
        }

        return response()->json(['totalSales' => $totalSales, 'totalOrders' => $totalOrders, 'couponAmount' => $CouponAmount, 'couponOrderCount' => $couponOrderCount, 'label' => $label, 'orderData' => $data, 'totalCancelled' => $totalCancelled, 'totalDelivered' => $totalDelivered, 'dateArray' => $dateArray, 'salesDelivered' => $salesDelivered, 'salesCancelled' => $salesCancelled, 'orders' => $kitchenOrders, 'dateBetween' => $dateBetween]);
    }
    public function cancelledReport(Request $request)
    {

        $kitchen_id = $request->user('api-kitchen')->id;
        $currentDay = Carbon::now()->format('Y-m-d');
        $cancelledOrders = [];
        $orderCount = 0;

        $orders = Order::where('order_status_id', 6)->where('kitchen_id', $kitchen_id)->where(function ($query) use ($request) {
            if ($request->filter == 'today') {
                $query->whereDate('created_at', date('Y-m-d'));
            } else if ($request->filter == 'week') {
                $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
            } else if ($request->filter == 'month') {
                $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            } else if ($request->filter == 'year') {
                $query->whereYear('created_at', date('Y'));
            }
        })->get();

        $orderCount = $orders->count();

        if ($orders->count()) {
            foreach ($orders as $key => $order) {
                $totalProductCount = 0;

                $totalProductCount = count($order->food);

                $cancelledOrders[$key] = [
                    'id' => $order->id,
                    'invoicePrefix' => $order->invoice_prefix,
                    'storeName' => $order->store_name,
                    'customerName' => $order->name,
                    'total' => $order->total,
                    'productCount' => $totalProductCount,
                    'statusId' => $order->status ? $order->status->id : 0,
                    'statusName' => $order->status ? $order->status->name : 'Failed',
                    'orderTime' => date('d-M-Y h:i a', strtotime($order->created_at)),
                ];
            }
        }

        return response()->json(['status' => 'success', 'cancelledOrders' => $cancelledOrders, 'orderCount' => $orderCount]);
    }
    public function completedReport(Request $request)
    {
        file_put_contents('completedReport.txt', "");
        error_log(json_encode($request->all()), 3, 'completedReport.txt');
        $kitchen_id = $request->user('api-kitchen')->id;
        $currentDay = Carbon::now()->format('Y-m-d');
        $cancelledOrders = [];
        $orderCount = 0;

        $orders = Order::where('order_status_id', 5)->where('kitchen_id', $kitchen_id)->where(function ($query) use ($request) {
            if ($request->filter == 'today') {
                $query->whereDate('created_at', date('Y-m-d'));
            } else if ($request->filter == 'week') {
                $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
            } else if ($request->filter == 'month') {
                $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            } else if ($request->filter == 'year') {
                $query->whereYear('created_at', date('Y'));
            }
        })->get();

        $orderCount = $orders->count();
        $completedOrders = [];
        if ($orders->count()) {
            foreach ($orders as $key => $order) {
                $totalProductCount = 0;

                $totalProductCount = count($order->food);

                $completedOrders[$key] = [
                    'id' => $order->id,
                    'invoicePrefix' => $order->invoice_prefix,
                    'storeName' => $order->store_name,
                    'customerName' => $order->name,
                    'total' => $order->total,
                    'productCount' => $totalProductCount,
                    'statusId' => $order->status ? $order->status->id : 0,
                    'statusName' => $order->status ? $order->status->name : '',
                    'orderTime' => date('d-M-Y h:i a', strtotime($order->created_at)),
                ];
            }
        }

        return response()->json(['status' => 'success', 'orders' => $completedOrders, 'orderCount' => $orderCount]);
    }
    public function couponReport(Request $request)
    {
        file_put_contents('couponReport.txt', "");
        error_log(json_encode($request->all()), 3, 'couponReport.txt');
        $kitchen_id = $request->user('api-kitchen')->id;
        $CouponHistory = CouponHistory::with(['coupon', 'order'])
            ->where(function ($query) use ($kitchen_id) {
                if (isset($kitchen_id)) {
                    $query->whereHas('order', function ($query1) use ($kitchen_id) {
                        $query1->where('kitchen_id', $kitchen_id);
                        $query1->where('order_status_id', '<>', 7);
                    });

                }
            })->where(function ($query) use ($request) {
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

        foreach ($CouponHistory as $key => $coupon) {
            // return response()->json([$coupon]);
            $couponReport[] = [
                'name' => $key,
                'code' => $coupon[0]->coupon->code,
                'count' => count($coupon),
                'discount' => $coupon->sum('amount'),
                'type' => $coupon[0]->coupon->created_by == 1 ? 'Super Admin' : ($coupon[0]->coupon->created_by == 2 ? 'Admin' : $coupon[0]->coupon->created_by == 3 ? 'kitchen' : ''),
            ];
        }
        return response()->json(['status' => 'success', 'orders' => $couponReport]);

    }
    public function OrderDispute(Request $request)
    {
        $kitchen_id = $request->user('api-kitchen')->id;
        $orders = OrderDispute::with('order.orderStatus', 'reason')->where(function ($query) use ($kitchen_id) {
            if (isset($kitchen_id)) {
                $query->whereHas('order', function ($query1) use ($kitchen_id) {
                    $query1->where('kitchen_id', $kitchen_id);
                });
            }
        })->where(function ($query) use ($request) {
            if ($request->filter == 'today') {
                $query->whereDate('created_at', date('Y-m-d'));
            } else if ($request->filter == 'week') {
                $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
            } else if ($request->filter == 'month') {
                $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            } else if ($request->filter == 'year') {
                $query->whereYear('created_at', date('Y'));
            }
        })->get();

        $disputedOrders = [];
        if ($orders->count()) {
            foreach ($orders as $key => $order) {
                // $totalProductCount=0;
                // $bundleProducts='';
                // $bundleProducts=$order->bundleProducts->unique('store_bundle_id');
                // $totalProductCount=count($order->products)+(!empty($bundleProducts)?count($bundleProducts):0);

                $disputedOrders[$key] = [
                    'id' => $order->order->id,
                    'invoicePrefix' => $order->order->invoice_prefix,
                    'storeName' => $order->order->store_name,
                    'customerName' => $order->order->name,
                    'total' => $order->order->total,
                    // 'productCount' => $totalProductCount,
                    'statusId' => $order->order->orderStatus->id,
                    'statusName' => $order->order->orderStatus->name,
                    'orderTime' => date('d-M-Y h:i a', strtotime($order->created_at)),
                ];
            }
        }
        return response()->json(['status' => 'success', 'orders' => $disputedOrders]);

    }
}
