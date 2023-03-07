<?php

/**
 *
 *
 * Author :Ananthu
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\DeliveryCharge;
use App\Model\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DeliveryChargeController extends Controller
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
        if ($request->ajax()) {

            $query = DeliveryCharge::with(['state.country'])->select('delivery_charges.*')->orderBy('id', 'DESC');

            return $datatables->eloquent($query)
                ->addColumn('status', function (DeliveryCharge $deliveryCharge) {

                    return ($deliveryCharge->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');

                })

                ->addColumn('start_date', function (DeliveryCharge $deliveryCharge) {
                    return Carbon::parse($deliveryCharge->start_date)->format('d-m-Y');
                })
                ->addColumn('end_date', function (DeliveryCharge $deliveryCharge) {
                    if (!empty($deliveryCharge->end_date)) {
                        return Carbon::parse($deliveryCharge->end_date)->format('d-m-Y');

                    } else {

                        return '--';

                    }

                })
            //   ->addColumn('state', function (DeliveryCharge $deliveryCharge) {

            //     return $deliveryCharge->state->getTranslation('name','en');
            // })
            //         ->addColumn('country', function (DeliveryCharge $deliveryCharge) {

            //     return $deliveryCharge->state->country->getTranslation('name','en');
            // })

                ->addColumn('charge', function (DeliveryCharge $deliveryCharge) {
                    return number_format($deliveryCharge->charge, 2);
                })
                ->addColumn('action', function (DeliveryCharge $deliveryCharge) {
                    return '<a href="' . route('admin.delivery-charge.edit', $deliveryCharge->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
              <a  data-toggle="modal" href="#delete_delivery_charge" data-href="' . route('admin.delivery-charge.destroy', $deliveryCharge->id) . '" class="btn btn-sm btn-clean btn-icon delivery_charge-delete" title="Delete"><i class="la la-trash"></i></a>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.delivery_charge.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.delivery_charge.form')->with([

            'delivery_charge' => new DeliveryCharge(),
            'states' => State::whereStatus(1)->get()->pluck('name', 'id'),
            'country' => Country::whereStatus(1)->orderBy('name', 'ASC')->get()->pluck('name', 'id'),

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
        $this->validate($request, [

            'charge' => 'required|numeric',
            'start_date' => 'required',
            'status' => 'required|boolean',

        ]);
        if (!empty($request->end_date)) {

            $request->merge([
                'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),

            ]);

        }
        $request->merge([
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),

        ]);
        $deliveryCharge = DeliveryCharge::where('state_id', $request->state_id)->where('country_id', $request->country_id)->first();
        if (empty($deliveryCharge)) {
            $deliveryCharge = DeliveryCharge::create($request->all());
        } else {
            $deliveryCharge->update($request->all());
        }
        return redirect()->route('admin.delivery-charge.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Deliverycharge  $Deliverycharge
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryCharge $deliveryCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Deliverycharge  $Deliverycharge
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryCharge $deliveryCharge)
    {
        return view('admin.delivery_charge.form')->with([
            'delivery_charge' => $deliveryCharge,
            'states' => State::whereStatus(1)->get()->pluck('name', 'id'),
            'country' => Country::whereStatus(1)->orderBy('name', 'ASC')->get()->pluck('name', 'id'),

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Deliverycharge  $Deliverycharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryCharge $deliveryCharge)
    {
        $this->validate($request, [

            'charge' => 'required|numeric',
            'start_date' => 'required',
            'status' => 'required|boolean',

        ]);

        if (!empty($request->end_date)) {

            $request->merge([
                'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),

            ]);

        }
        $request->merge([
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),

        ]);

        $deliveryCharge->update($request->all());

        return redirect()->route('admin.delivery-charge.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Deliverycharge  $Deliverycharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryCharge $deliveryCharge)
    {
        $deliveryCharge->delete();
        return response()->json('success');

    }
}
