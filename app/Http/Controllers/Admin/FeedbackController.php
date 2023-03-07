<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class FeedbackController extends Controller
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

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Feedback')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = Feedback::with(['customer', 'kitchen', 'deliveryPartner'])->where('type', $request->type)->select('feedback.*')->orderBy('id', 'DESC');

            return $datatables->eloquent($query)
                ->addColumn('name', function (Feedback $Feedback) {
                    return ($Feedback->type == 0) ? ($Feedback->customer_id ? $Feedback->customer->name : '-') : ($Feedback->type == 1 ? ($Feedback->kitchen_id ? $Feedback->kitchen->name : '-') : ($Feedback->delivery_partner_id ? $Feedback->deliveryPartner->name : '-'));
                })

                ->addColumn('action', function (Feedback $Feedback) {
                    return (auth()->user()->hasPermissionTo('Delete Feedback') ? '<a  data-toggle="modal" href="#delete_feedback" data-href="' . route('admin.feedback.destroy', $Feedback->id) . '" class="btn btn-sm btn-clean btn-icon feedback-delete" title="Delete"><i class="la la-trash"></i></a>' : '');

                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
        return view('admin.feedback.list');
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
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Feedback')) {
            abort(403);
        }
        $feedback->delete();
        return response()->json('success');
    }
}
