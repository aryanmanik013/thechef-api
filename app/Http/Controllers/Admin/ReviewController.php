<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Kitchen;
use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class ReviewController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Datatables $datatables)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Review')) {
            abort(403);
        }
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->id == 1) {

                $query = Review::with(['customer', 'kitchen'])->where(function ($query) use ($request) {
                    if (isset($request->kitchen)) {
                        $query->where('kitchen_id', $request->kitchen);
                    }
                })
                    ->select('reviews.*');
            } else {
                $query = Review::with(['customer', 'kitchen'])->where(function ($query) use ($request) {

                    $query->whereHas('kitchen', function ($query) {

                        $query->Where('country_id', Auth::guard('admin')->user()->country_id);

                    });

                    if (isset($request->kitchen)) {
                        $query->where('kitchen_id', $request->kitchen);
                    }
                })
                    ->select('reviews.*');

            }
            return $datatables->eloquent($query)
                ->editColumn('status', function (Review $review) {
                    return '


                   <span class="switch switch-outline switch-icon switch-success">

                                      <label>

                                      <input type="checkbox" ' . ($review->status == 1 ? 'checked' : '') . ' name="checkbox" class="change_status" id="check" value="0" data-id="' . $review->id . '"  data-val="' . $review->status . '">



                                      <span></span>

                                      </label>

                                      </span>




                  ';

                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        if (Auth::guard('admin')->user()->id == 1) {
            $kitchen = Kitchen::where('status', 1)->get()->pluck('name', 'id');
        } else {
            $kitchen = Kitchen::Where('country_id', Auth::guard('admin')->user()->country_id)->where('status', 1)->get()->pluck('name', 'id');

        }
        return view('admin.review.list')->with(['kitchens' => $kitchen]);
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
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Review')) {
            abort(403);
        }
        $review->delete();
        return response()->json('success');
    }
    public function changeReviewStatus(Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Review')) {
            abort(403);
        }
        $review = Review::find($request->id);

        if ($request->value == 1) {

            $status = 0;
        } else {
            $status = 1;
        }
        $review->update(['status' => $status]);
        return response()->json('success');

    }
}
