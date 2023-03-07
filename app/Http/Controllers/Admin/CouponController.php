<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Coupon;
use App\Model\CouponCategory;
use App\Model\FoodCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class CouponController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Coupon')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = Coupon::select('coupons.*')->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (Coupon $coupon) {
                    return ($coupon->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->editColumn('start_date', function (Coupon $coupon) {
                    return (Carbon::parse($coupon->start_date)->format('d-m-Y'));
                })
                ->editColumn('expiry_date', function (Coupon $coupon) {
                    return (Carbon::parse($coupon->expiry_date)->format('d-m-Y'));
                })

                ->addColumn('action', function (Coupon $coupon) {
                    return (auth()->user()->hasPermissionTo('Edit Coupon') ? '<a href="' . route('admin.coupon.edit', $coupon->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete Coupon') ? '<a  data-toggle="modal" href="#delete_banner" data-href="' . route('admin.coupon.destroy', $coupon->id) . '" class="btn btn-sm btn-clean btn-icon banner-delete" title="Delete"><i class="la la-trash"></i></a>' : '');

                })
                ->rawColumns(['action', 'status', 'start_date', 'expiry_date'])
                ->make(true);
        }
        return view('admin.coupon.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Coupon')) {
            abort(403);
        }
        return view('admin.coupon.form')->with([
            'categories' => FoodCategory::where('status', 1)->get(),
            'coupon' => new Coupon(),
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
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'uses_total' => 'required',
            'start_date' => 'required',
            'expiry_date' => 'required',
            //'status'  => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
        ]);

//         $coupon = new Coupon();
        //         $coupon->name = $request->name;
        //         $coupon->code = $request->code;
        //         $coupon->uses_customer = $request->uses_customer;
        //         $coupon->uses_total = $request->uses_total;
        //         $coupon->balance = $request->uses_total;
        //         $coupon->start_date = Carbon::parse($request->start_date);
        //         $coupon->expiry_date = Carbon::parse($request->expiry_date);
        //         $coupon->discount_type = $request->discount_type;
        //         $coupon->discount = $request->discount;
        //         $coupon->minimum_amount = $request->minimum_amount;
        //         $coupon->status = $request->status;
        //         $couponid=$coupon->save();
        $request->request->add(['start_date' => Carbon::parse($request->start_date)->format('Y-m-d'), 'expiry_date' => Carbon::parse($request->expiry_date)->format('Y-m-d'), 'balance' => $request->uses_total]);
        //dd($request->all());
        $couponid = Coupon::create($request->all());
        //dd($couponid->id);
        $category_id = $request->category_id;
        //dd($category_id);
        if (!empty($category_id)) {
            foreach ($category_id as $value) {
                CouponCategory::create([
                    'coupon_id' => $couponid->id,
                    'food_category_id' => $value,
                ]);
            }
        }

        //$faq=Faq::create($request->all());
        return redirect()->route('admin.coupon.index')->with('message', ' Coupon Added Successfully..');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Coupon')) {
            abort(403);
        }
        return view('admin.coupon.form')->with([
            'categories' => FoodCategory::where('status', 1)->get(),
            'couponcategories' => Coupon::with('categories')->whereId($coupon->id)->first(),
            'coupon' => Coupon::whereId($coupon->id)->first(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'uses_total' => 'required',
            'start_date' => 'required',
            'expiry_date' => 'required',
            //'status'  => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
        ]);
        if ($request->uses_total > $coupon->uses_total) {
            $add = $request->uses_total - $coupon->uses_total;
            $coupon->balance += $add;
        } else {

            $minus = $coupon->uses_total - $request->uses_total;
            if ($request->uses_total >= $coupon->balance) {
                $coupon->balance -= $minus;
            } else {
                $coupon->balance = $request->uses_total;
            }
        }
//         $coupon->name = $request->name;
        //         $coupon->code = $request->code;
        //         $coupon->uses_total = $request->uses_total;
        //         $coupon->balance = $request->uses_total;
        //         $coupon->start_date = Carbon::parse($request->start_date);
        //         $coupon->expiry_date = Carbon::parse($request->expiry_date);
        //         $coupon->discount_type = $request->discount_type;
        //         $coupon->discount = $request->discount;
        //         $coupon->minimum_amount = $request->minimum_amount;
        //         $coupon->uses_customer = $request->uses_customer;
        //         $coupon->status = $request->status;
        //         $coupon->save();
        $request->request->add(['start_date' => Carbon::parse($request->start_date)->format('Y-m-d'), 'expiry_date' => Carbon::parse($request->expiry_date)->format('Y-m-d'), 'balance' => $coupon->balance]);
        $coupon->update($request->all());
        /////category edit///////
        $coupon_category = CouponCategory::where('coupon_id', $coupon->id)->delete();
        $category_id = $request->category_id;
        //dd($category_id);
        if (!empty($category_id)) {
            foreach ($category_id as $value) {
                CouponCategory::create([
                    'coupon_id' => $coupon->id,
                    'food_category_id' => $value,
                ]);
            }
        }
        /////close category edit////

        return redirect()->route('admin.coupon.index')->with('message', ' Coupon Updated Successfully..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Coupon')) {
            abort(403);
        }
        $coupon->delete();
        return response()->json('success');
    }
}
