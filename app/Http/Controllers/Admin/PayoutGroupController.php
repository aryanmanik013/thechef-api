<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Day;
use App\Model\DeliveryPartner;
use App\Model\Kitchen;
use App\Model\PayoutGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PayoutGroupController extends Controller
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
    public function index(Request $request, Datatables $datatables)
    {
        //
        if ($request->ajax()) {
            $query = PayoutGroup::select('payout_groups.*');

            return $datatables->eloquent($query)
                ->editColumn('status', function (PayoutGroup $payoutGroup) {
                    return ($payoutGroup->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->editColumn('type', function (PayoutGroup $payoutGroup) {
                    return ($payoutGroup->type == 1 ? 'Kitchen' : 'Delivery');
                })
                ->editColumn('payment_frequency', function (PayoutGroup $payoutGroup) {
                    return ($payoutGroup->payment_frequency == 1 ? 'Month' : 'Week');
                })
                ->editColumn('percentage', function (PayoutGroup $payoutGroup) {
                    return (number_format($payoutGroup->percentage, 2));
                })
                ->editColumn('payment_date', function (PayoutGroup $payoutGroup) {
                    return (Carbon::parse($payoutGroup->payment_date)->format('d-m-Y'));
                })

                ->addColumn('action', function (PayoutGroup $payoutGroup) {
                    return '<a href="' . route('admin.payout_group.edit', $payoutGroup->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
             <a data-toggle="modal" href="#delete-payout-group" data-href="' . route('admin.payout_group.destroy', $payoutGroup->id) . '" class="btn btn-sm btn-clean btn-icon payout-group-delete" title="Delete"><i class="la la-trash"></i></a>';

                })
                ->rawColumns(['action', 'status', 'payment_date', 'payment_frequency', 'type'])
                ->make(true);
        }
        return view('admin.payout_group.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $payout = PayoutGroup::whereId($payoutGroup->id)->first();
        if ($payout->type == 1) {
            $kitchen = Kitchen::where('payout_group_id', $payout->id)->get();
            if ($kitchen->count() > 0) {
                return response()->json(['message' => 'You cannot remove this Payout Group', 'status' => 'fail']);
            } else {
                $payoutGroup->delete();
                return response()->json(['message' => 'Success', 'status' => 'success']);
            }
        } else {
            $delivery = DeliveryPartner::where('payout_group_id', $payout->id)->get();
            if ($delivery->count() > 0) {
                return response()->json(['message' => 'You cannot remove this Payout Group', 'status' => 'fail']);
            } else {
                $payoutGroup->delete();
                return response()->json(['message' => 'Success', 'status' => 'success']);
            }
        }

    }
}
