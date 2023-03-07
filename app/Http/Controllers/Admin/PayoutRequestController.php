<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Day;
use App\Model\DeliveryPartnerBanks;
use App\Model\DeliveryPartnerPayouts;
use App\Model\KitchenBanks;
use App\Model\KitchenPayouts;
use App\Model\PayoutGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class PayoutRequestController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function kitchen(Request $request, Datatables $datatables)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View PayoutRequest')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = KitchenPayouts::with(['payoutGroup', 'kitchen'])->select('kitchen_payouts.*')->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (KitchenPayouts $kitchenPayouts) {
                    return (
                        ' <a href="#" class="btn btn-sm btn-clean btn-icon btn_bank_details" title="View Bank" data-id="' . $kitchenPayouts->kitchen->id . '"><i class="la la-eye"></i></a>') . (
                        $kitchenPayouts->status == 0 ? '<button type="button" data-id="' . $kitchenPayouts->id . '" data-toggle="modal" data-target="#complete-payout" class="btn btn-outline-success complete-payout">Done</button>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Completed</span>
             ');
                })
                ->editColumn('payout_method', function (KitchenPayouts $kitchenPayouts) {
                    return ($kitchenPayouts->payout_method == 1 ? 'Cash' : 'Online');
                })

                ->editColumn('payable_amount', function (KitchenPayouts $kitchenPayouts) {
                    return (number_format($kitchenPayouts->payable_amount, 2));
                })
                ->editColumn('total_amount', function (KitchenPayouts $kitchenPayouts) {
                    return (number_format($kitchenPayouts->total_amount, 2));
                })
                ->editColumn('start_date', function (KitchenPayouts $kitchenPayouts) {
                    return (Carbon::parse($kitchenPayouts->start_date)->format('d-m-Y'));
                })
                ->editColumn('end_date', function (KitchenPayouts $kitchenPayouts) {
                    return (Carbon::parse($kitchenPayouts->end_date)->format('d-m-Y'));
                })
                ->editColumn('payout_generated_date', function (KitchenPayouts $kitchenPayouts) {
                    return (Carbon::parse($kitchenPayouts->payout_generated_date)->format('d-m-Y'));
                })

                ->rawColumns(['status', 'start_date', 'end_date', 'payout_generated_date', 'payout_method'])
                ->make(true);
        }
        return view('admin.kitchen_payouts.list');
    }

    public function DeliveryPartner(Request $request, Datatables $datatables)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View PayoutRequest')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = DeliveryPartnerPayouts::with(['payoutGroup', 'deliveryPartner'])->select('delivery_partner_payouts.*')->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
                    return (' <a href="#" class="btn btn-sm btn-clean btn-icon btn_bank_details" title="View Bank" data-id="' . $deliveryPartnerPayouts->deliveryPartner->id . '"><i class="la la-eye"></i></a>') . ($deliveryPartnerPayouts->status == 0 ? '<button type="button" data-id="' . $deliveryPartnerPayouts->id . '" data-toggle="modal" data-target="#complete-payout" class="btn btn-outline-success complete-payout">Done</button>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Completed</span>     <a href="" class="btn btn-sm btn-clean btn-icon" title="View Bank"><i class="la la-eye"></i></a>');
                })
            //   ->editColumn('payout_method', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
            //       return ($deliveryPartnerPayouts->payout_method==1 ? 'Cash' :  'Online');
            //   })

                ->editColumn('payable_amount', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
                    return (number_format($deliveryPartnerPayouts->payable_amount, 2));
                })
                ->editColumn('total_amount', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
                    return (number_format($deliveryPartnerPayouts->total_amount, 2));
                })
                ->editColumn('start_date', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
                    return (Carbon::parse($deliveryPartnerPayouts->start_date)->format('d-m-Y'));
                })
                ->editColumn('end_date', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
                    return (Carbon::parse($deliveryPartnerPayouts->end_date)->format('d-m-Y'));
                })
                ->editColumn('payout_generated_date', function (DeliveryPartnerPayouts $deliveryPartnerPayouts) {
                    return (Carbon::parse($deliveryPartnerPayouts->payout_generated_date)->format('d-m-Y'));
                })

                ->rawColumns(['status', 'start_date', 'end_date', 'payout_generated_date', 'payout_method'])
                ->make(true);
        }
        return view('admin.delivery_partner_payouts.list');
    }

    public function kitchenCompletePayout(KitchenPayouts $kitchenPayouts, Request $request)
    {

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit PayoutRequest')) {
            abort(403);
        }
        $kitchenPayouts = KitchenPayouts::find($request->id);

        $kitchenPayouts->status = 1;
        $kitchenPayouts->transaction_id = $request->transaction_id;
        $kitchenPayouts->remarks = $request->remarks;
        $kitchenPayouts->update();
        return response()->json(['status' => 'success']);

    }
    public function deliveryPartnerCompletePayout(DeliveryPartnerPayouts $deliveryPartnerPayouts, Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit PayoutRequest')) {
            abort(403);
        }
        $deliveryPartnerPayouts = DeliveryPartnerPayouts::find($request->id);

        $deliveryPartnerPayouts->status = 1;
        $deliveryPartnerPayouts->transaction_id = $request->transaction_id;
        $deliveryPartnerPayouts->remarks = $request->remarks;
        $deliveryPartnerPayouts->save();
        return response()->json(['status' => 'success']);

    }

    public function getKitchenBank(Request $request)
    {

        $kitchen_bank = KitchenBanks::where('kitchen_id', $request->kitchen_id)->first();

        return response()->json(['bank' => $kitchen_bank]);

    }
    public function getDeliveryBank(Request $request)
    {

        $delivery_partner_bank = DeliveryPartnerBanks::where('delivery_partner_id', $request->delivery_partner_id)->first();

        return response()->json(['bank' => $delivery_partner_bank]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create PayoutRequest')) {
            abort(403);
        }
        return view('admin.payout_group.form')->with([

            'payout_group' => new PayoutGroup(),
            'days' => Day::whereStatus(1)->get()->pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->request->add(['payment_date' => Carbon::parse($request->payment_date)->format('Y-m-d')]);
        PayoutGroup::create($request->all());
        return redirect()->route('admin.payout_group.index')->with('message', '   Payout Group Added Successfully..');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\PayoutGroup  $payoutGroup
     * @return \Illuminate\Http\Response
     */
    public function show(PayoutGroup $payoutGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\PayoutGroup  $payoutGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(PayoutGroup $payoutGroup)
    {
        //
        return view('admin.payout_group.form')->with(['payout_group' => PayoutGroup::with('day')->find($payoutGroup->id),
            'days' => Day::whereStatus(1)->get()->pluck('name', 'id'),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\PayoutGroup  $payoutGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayoutGroup $payoutGroup)
    {
        //
        //dd($request->all());
        if (!empty($request->payment_date)) {
            $request->request->add(['payment_date' => Carbon::parse($request->payment_date)->format('Y-m-d')]);
        }
        //dd($request->all());
        $payoutGroup->update($request->all());
        return redirect()->route('admin.payout_group.index')->with('message', ' Payout Group Updated Successfully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\PayoutGroup  $payoutGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayoutGroup $payoutGroup)
    {
        //
        $payoutGroup->delete();
        return response()->json('success');
    }
}
