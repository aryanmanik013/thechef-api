<?php

/**
 *
 *
 * Author :Ananthu
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\KitchenInappropriateReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class KitchenInappropriateReportController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View InappropriateReport')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = KitchenInappropriateReport::with(['kitchen', 'customer', 'order'])->where('type', $request->type)->select('kitchen_inappropriate_reports.*')->orderBy('id', 'DESC');

            return $datatables->eloquent($query)
                ->addColumn('order_id', function (KitchenInappropriateReport $kitchenInappropriateReport) {
                    return ($kitchenInappropriateReport->order_id ? $kitchenInappropriateReport->order->invoice_prefix . $kitchenInappropriateReport->order->id : '-');
                })

            //       ->editColumn('kitchen_name', function (KitchenInappropriateReport $kitchenInappropriateReport){
            //     return strip_tags($kitchenInappropriateReport->kitchen->getTranslation('name','en'));
            // })

            //   ->addColumn('action', function (KitchenInappropriateReport $kitchenInappropriateReport) {
            //       return '<a  data-toggle="modal" href="#delete_inappropriate_report" data-href="'.route('admin.inappropriate-report.destroy',$kitchenInappropriateReport->id ).'" class="btn btn-sm btn-clean btn-icon inappropriate_report-delete" title="Delete"><i class="la la-trash"></i></a>';
            //   })
                ->rawColumns(['action', 'status', 'order_id'])
                ->make(true);
        }
        return view('admin.inappropriate_report.list');
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
     * @param  \App\Model\KitchenInappropriateReport  $kitchenInappropriateReport
     * @return \Illuminate\Http\Response
     */
    public function show(KitchenInappropriateReport $kitchenInappropriateReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\KitchenInappropriateReport  $kitchenInappropriateReport
     * @return \Illuminate\Http\Response
     */
    public function edit(KitchenInappropriateReport $kitchenInappropriateReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\KitchenInappropriateReport  $kitchenInappropriateReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KitchenInappropriateReport $kitchenInappropriateReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\KitchenInappropriateReport  $kitchenInappropriateReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(KitchenInappropriateReport $kitchenInappropriateReport)
    {
        //
    }
}
