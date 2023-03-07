<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Model\Kitchen;
use App\Model\Order;
use App\Model\OrderFood;
use App\Model\OrderHistory;
use App\Model\OrderPayment;
use App\Model\OrderStatus;
use App\Model\OrderTotal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
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

    public function index(Request $request, Datatables $datatables)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Order')) {
            abort(403);
        }

        if ($request->ajax()) {

            if (Auth::guard('admin')->user()->id == 1) {
                $query = Order::with('status', 'kitchen')->where(function ($query) use ($request) {

                    if (isset($request->kitchen)) {
                        $query->where('kitchen_id', $request->kitchen);
                    }
                    if (isset($request->statusId)) {
                        $query->where('order_status_id', $request->statusId);
                    }

                    if ($request->filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    } else if ($request->filter == 'week') {
                        $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                    } else if ($request->filter == 'month') {
                        $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                    } else if ($request->filter == 'year') {
                        $query->whereYear('created_at', date('Y'));
                    }
                })->select('orders.*')->orderBy('id', 'DESC');
            } else {

                $query = Order::with('status', 'kitchen')->where(function ($query) use ($request) {
                    $query->whereHas('kitchen', function ($query) {

                        $query->Where('country_id', Auth::guard('admin')->user()->country_id);

                    });

                    if (isset($request->kitchen)) {
                        $query->where('kitchen_id', $request->kitchen);
                    }
                    if (isset($request->statusId)) {
                        $query->where('order_status_id', $request->statusId);
                    }

                    if ($request->filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    } else if ($request->filter == 'week') {
                        $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
                    } else if ($request->filter == 'month') {
                        $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                    } else if ($request->filter == 'year') {
                        $query->whereYear('created_at', date('Y'));
                    }
                })->select('orders.*')->orderBy('id', 'DESC');

            }

            return $datatables->eloquent($query)

                ->editColumn('created_at', function (Order $order) {
                    return Carbon::parse($order->created_at)->format('d-m-Y');
                })
                ->editColumn('total', function (Order $order) {
                    return number_format($order->total, 2);
                })
                ->editColumn('id', function (Order $order) {
                    return $order->invoice_prefix . $order->id;
                })
                ->addColumn('status', function (Order $order) {
                    return $order->order_status_id == 0 ? 'Pending' : $order->status->name;
                })

            /*      ->addColumn('status', function (Order $order) {
            return $order->status->name;
            })*/

                ->addColumn('action', function (Order $order) {
                    return (auth()->user()->hasPermissionTo('View Order') ? '<a href="' . route('admin.order.show', $order->id) . '" class="btn btn-sm btn-clean btn-icon" title="View details"><i class="la la-eye"></i></a>
              ' : '');

                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        if (Auth::guard('admin')->user()->id == 1) {
            $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');
        } else {

            $kitchen = Kitchen::where('status', 1)->where('country_id', Auth::guard('admin')->user()->country_id)->get()->pluck('name', 'id');
        }
        $orderSatatus = OrderStatus::get()->pluck('name', 'id');
        return view('admin.order.list')->with(['kitchens' => $kitchen, 'orderSatatus' => $orderSatatus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Order')) {
            abort(403);
        }
        $orders = Order::with(['country', 'kitchen', 'status', 'deliveryPartner'])->find($order->id);

        $history = OrderHistory::with('status')->where('order_id', $order->id)->orderBy('id', 'desc')->get();
        $canceled_history = OrderHistory::with('status')->where('order_id', $order->id)->where('order_status_id', '6')->orderBy('id', 'desc')->first();
        $status_id = $history->pluck('order_status_id')->toArray();

        return view('admin.order.view')->with([
            'foods' => OrderFood::where('order_id', $order->id)->get(),
            'ordertotal' => OrderTotal::where('order_id', $order->id)->get(),
            'statuses' => OrderStatus::whereNotIn('id', $status_id)->get(),
            'histories' => $history,
            'canceled_history' => $canceled_history,
            'order' => $orders,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        //dd($order);

    }
    public function invoice($order)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Order')) {
            abort(403);
        }
        return view('admin.order.invoice.view')->with([
            'order' => Order::whereId($order)->first(),
            'foods' => OrderFood::with('food')->where('order_id', $order)->get(),
            'ordertotal' => OrderTotal::where('order_id', $order)->get(),
            'payment' => OrderPayment::where('order_id', $order)->get(),
        ]);
        //return view('admin.order.invoice.view');
    }

    public function delivery_assign(Request $request)
    {
        $delivery_boy_id = $request->delivery_boy_id;
        $order_id = $request->order_id;
        if (!empty($order_id)) {
            $order = Order::find($order_id);
            $order->update(['delivery_boy_id' => $delivery_boy_id, 'order_status_id' => $request->order_status_id]);
        }

        OrderHistory::create([
            'order_id' => $order_id,
            'order_status_id' => $request->order_status_id,
            'comment' => 'The order has been assigned to ' . $request->name,
            'notify' => 1]);

        return response()->json('success');
    }

    public function updateStatus(Request $request)
    {

        $order_id = $request->order_id;
        $comment = $request->comment;

        OrderHistory::create([
            'order_id' => $order_id,
            'order_status_id' => $request->order_status_id,
            'comment' => $comment,
            'notify_sms' => $request->notify_sms ? $request->notify_sms : 1,
            'notify_email' => $request->notify_email ? $request->notify_email : 1,
            'notify_push' => $request->notify_push ? $request->notify_push : 1]);

        if (!empty($order_id)) {
            //$order=Order::with(['histories','orderStatus'])->find($order_id);

            $order = Order::with(['histories' => function ($query) use ($request) {
                $query->with('status')->where('order_status_id', $request->order_status_id)->first();
            }])->whereId($request->order_id)->first();

            $order->update(['order_status_id' => $request->order_status_id]);

        }
        Mail::to($order->email, $order->name)->send(new OrderStatusMail($order));
        return response()->json('success');

    }
}
