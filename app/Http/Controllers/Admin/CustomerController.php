<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Model\Gender;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class CustomerController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Customer')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = Customer::select('customers.*');
            return $datatables->eloquent($query)

            // ->addColumn('action', function (Customer $customer) {
            //         return '<a href="'.route('admin.service.edit',$service->id).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
            //                     <i class="flaticon-edit"></i>
            //                   </a>
            //                   <a data-toggle="modal" href="#Delete_Log" data-href="'.route('admin.service.destroy',$service->id).'" class="btn btn-sm btn-clean btn-icon btn-icon-md service-delete" title="Delete">
            //                     <i class="flaticon-delete"></i>
            //                   </a>';
            //     })
                ->editColumn('status', function (Customer $customer) {
                    return '


                   <span class="switch switch-outline switch-icon switch-success">

                                      <label>

                                      <input type="checkbox" ' . ($customer->status == 1 ? 'checked' : '') . ' name="checkbox" class="change_customer_status" id="check" value="0" data-id="' . $customer->id . '"  data-val="' . $customer->status . '">



                                      <span></span>

                                      </label>

                                      </span>




                  ';
                })

            //   ->addColumn('provider',function (Customer $customer) {
            //       return $customer->provider;
            //   })

                ->addColumn('phone', function (Customer $customer) {
                    //return (!empty($customer->phone_prefix)) ? '+'.$customer->phone_prefix.' '.$customer->phone : ' ';
                    return (!empty($customer->phone)) ? $customer->phone : ' ';
                })
                ->addColumn('action', function (Customer $customer) {
                    return (auth()->user()->hasPermissionTo('Edit Customer') ? '<a href="' . route('admin.customer.edit', $customer->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('View Customer') ? '<a href="' . route('admin.customer.show', $customer->id) . '" class="btn btn-sm btn-clean btn-icon" title="View details"><i class="la la-eye"></i></a>' : '');

                })
                ->rawColumns(['action', 'status', 'provider', 'phone'])
                ->make(true);
        }

        return view('admin.customer.list');
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
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
//         if (!auth()->user()->hasPermissionTo('View Customer')) {
        //             abort(403);
        //         }
        return view('admin.customer.detail')->with(['customer' => Customer::with('gender')->find($customer->id),
            'addresses' => CustomerAddress::with(['state', 'country'])->where('customer_id', $customer->id)->get(),
            'orders' => Order::with(['state', 'country', 'kitchen', 'food'])->where('customer_id', $customer->id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Customer')) {
            abort(403);
        }
        //  return view('admin.customer.edit')->with(['customer' => Customer::with('gender')->find($customer->id),
        //     'genders' => Gender::whereStatus(1)->get()->pluck('name','id'),
        //     'isd_codes'=> Country::where('phone_prefix','!=',NULL)->get()]);

        return view('admin.customer.edit')->with(['customer' => Customer::with('gender')->find($customer->id),
            'genders' => Gender::whereStatus(1)->get()->pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        // dd($request->status);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'gender_id' => 'required',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id . ',id,deleted_at,NULL',
            'phone' => 'required|numeric|unique:customers,phone,' . $customer->id . ',id,deleted_at,NULL',

        ]);

        if ($request->get('password')) {
            $rules['password'] = 'required|min:8|same:password';
            $rules['password_confirmation'] = 'required|same:password';

            $this->validate($request, $rules);
        }

        $customer->fill($request->only(['name', 'email', 'status', 'phone_prefix', 'phone', 'gender_id']));

        //dd($customer->fill($request->only(['name','email','status','phone_prefix','phone','gender_id'])));

        if ($request->get('password')) {
            $customer->password = bcrypt($request->input('password'));
        }
        //$customer->phone_prefix = trim($request->phone_prefix,"+");
        $customer->status = $request->status;
        $customer->save();

        return redirect()->route('admin.customer.index')->with('message', ' Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Customer')) {
            abort(403);
        }
        $customer->delete();
        return response()->json('success');
    }

    public function changeCustomerStatus(Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Customer')) {
            abort(403);
        }
        $customerStatus = Customer::find($request->id);

        if ($request->value == 1) {

            $status = 0;
        } else {
            $status = 1;
        }
        $customerStatus->update(['status' => $status]);
        return response()->json('success');

    }
}
