<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Model\DeliveryPartner;
use App\Model\Kitchen;
use App\Model\SmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SmsHelper;
use Yajra\Datatables\Datatables;

class SmsNotificationController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View SmsNotification')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = SmsNotification::query()->where('created_by', 2)->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (SmsNotification $smsNotification) {

                    return ($smsNotification->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.sms_notification.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create SmsNotification')) {
            abort(403);
        }
        return view('admin.sms_notification.form')->with([
            'notification' => new SmsNotification(),
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
        $this->validate($request, [
            'title' => 'required|max:64',
            'message' => 'required',
            'user_type' => 'required',
            //'route' => 'required',
        ]);
        $request->merge(['created_by' => 2]);
        if ($request->user_type == 1) {
            $phones = Customer::where('status', 1)->pluck('phone')->toArray();

        } elseif ($request->user_type == 2) {
            $phones = Kitchen::where('status', 1)->pluck('phone')->toArray();
        } elseif ($request->user_type == 3) {
            $phones = DeliveryPartner::where('status', 1)->pluck('phone')->toArray();
        }

        // $phones_array=array_chunk($phones,10,true);
        SmsNotification::create($request->all());
        //$phones_array=[9746092972,9895259006,9048910010];

        SmsHelper::sendAll($phones, $request->message);
        return redirect()->route('admin.sms-notification.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\NotificationTemplate  $notificationTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(SmsNotification $smsNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\NotificationTemplate  $notificationTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsNotification $smsNotification)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit SmsNotification')) {
            abort(403);
        }
        return view('admin.sms_notification.form')->with([
            'notification' => $smsNotification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\NotificationTemplate  $notificationTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsNotification $smsNotification)
    {
        //
        $this->validate($request, [
            'title' => 'required|max:64',
            'message' => 'required',
            // 'parameter' => 'required',
            //'route' => 'required',
        ]);
        $request->merge(['created_by' => 2]);
        $smsNotification->update($request->all());
        //dd(DB::getQueryLog());
        return redirect()->route('admin.sms-notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\NotificationTemplate  $notificationTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsNotification $smsNotification)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete SmsNotification')) {
            abort(403);
        }
        $smsNotification->delete();
        return response()->json('success');
    }
}
