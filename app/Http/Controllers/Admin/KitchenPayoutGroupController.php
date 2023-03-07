<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Day;
use App\Model\KitchenPayoutGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class KitchenPayoutGroupController extends Controller
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
            $query = KitchenPayoutGroup::with('day')->select('kitchen_payout_groups.*')->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (KitchenPayoutGroup $kitchenPayoutGroup) {
                    return ($kitchenPayoutGroup->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->editColumn('payment_frequency', function (KitchenPayoutGroup $kitchenPayoutGroup) {
                    return ($kitchenPayoutGroup->payment_frequency == 1 ? 'Week' : 'Month');
                })
                ->editColumn('payment_date', function (KitchenPayoutGroup $kitchenPayoutGroup) {
                    return (Carbon::parse($kitchenPayoutGroup->payment_date)->format('d-m-Y'));
                })

                ->addColumn('action', function (KitchenPayoutGroup $kitchenPayoutGroup) {
                    return '<a href="' . route('admin.kitchen_payout_group.edit', $kitchenPayoutGroup->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
             <a data-toggle="modal" href="#delete-kitchen-payout-group" data-href="' . route('admin.kitchen_payout_group.destroy', $kitchenPayoutGroup->id) . '" class="btn btn-sm btn-clean btn-icon kitchen-payout-group-delete" title="Delete"><i class="la la-trash"></i></a>';

                })
                ->rawColumns(['action', 'status', 'payment_date', 'payment_frequency'])
                ->make(true);
        }
        return view('admin.kitchen_payout_group.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.kitchen_payout_group.form')->with([

            'kitchen_payout_group' => new KitchenPayoutGroup(),
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
        //
        $request->request->add(['payment_date' => Carbon::parse($request->payment_date)->format('Y-m-d')]);
        KitchenPayoutGroup::create($request->all());
        return redirect()->route('admin.kitchen_payout_group.index')->with('message', '  Kitchen Payment Groups Added Successfully..');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\KitchenPayoutGroup  $kitchenPayoutGroup
     * @return \Illuminate\Http\Response
     */
    public function show(KitchenPayoutGroup $kitchenPayoutGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\KitchenPayoutGroup  $kitchenPayoutGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(KitchenPayoutGroup $kitchenPayoutGroup)
    {
        //
        return view('admin.kitchen_payout_group.form')->with(['kitchen_payout_group' => KitchenPayoutGroup::with('day')->find($kitchenPayoutGroup->id),
            'days' => Day::whereStatus(1)->get()->pluck('name', 'id'),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\KitchenPayoutGroup  $kitchenPayoutGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KitchenPayoutGroup $kitchenPayoutGroup)
    {
        //
        // dd($request->all());
        $request->request->add(['payment_date' => Carbon::parse($request->payment_date)->format('Y-m-d')]);
        $kitchenPayoutGroup->update($request->all());
        return redirect()->route('admin.kitchen_payout_group.index')->with('message', ' Kitchen Payment Groups Updated Successfully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\KitchenPayoutGroup  $kitchenPayoutGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(KitchenPayoutGroup $kitchenPayoutGroup)
    {
        //
        $kitchenPayoutGroup->delete();
        return response()->json('success');
    }
}
