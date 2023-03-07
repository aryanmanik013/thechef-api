<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Information;
use App\Model\Notification;
use App\Model\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PushNotificationHelper;
use Yajra\Datatables\Datatables;

class NotificationController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View PushNotification')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = Notification::query()->where('user_id', 0)->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (Notification $notification) {

                    return ($notification->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->addColumn('action', function (Notification $notification) {
                    return (auth()->user()->hasPermissionTo('Edit PushNotification') ? '<a href="' . route('admin.notification.edit', $notification->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete PushNotification') ? '<a data-toggle="modal" href="#delete-notification" data-href="' . route('admin.notification.destroy', $notification->id) . '" class="btn btn-sm btn-clean btn-icon notification-delete" title="Delete"><i class="la la-trash"></i></a> ' : '');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.notification.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create PushNotification')) {
            abort(403);
        }
        return view('admin.notification.form')->with([
            'notification' => new Notification(),
            'information' => Information::where('status', 1)->get(),

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
            'parameter' => 'required',
            'route' => 'required',
        ]);

        $title = $request->title;
        $body = $request->message;
        if ($request->user_type == 1) {
            $token = PushNotification::where('user_type', 1)->get()->pluck('token');
        } elseif ($request->user_type == 2) {
            $token = PushNotification::where('user_type', 2)->get()->pluck('token');
        } elseif ($request->user_type == 3) {
            $token = PushNotification::where('user_type', 3)->get()->pluck('token');
        }
        $parameter = [];
        if ($request->route == 2) {
            $route = 'KitchenDetail';
            $parameter = ['storeType' => $request->parameter];

        } else {
            $route = 'Information';
            $parameter = ['slug' => $request->parameter];
        }

        if (!empty($token)) {

            $tokenArray = $token->toArray();
            // dd($tokenArray);
            $status = PushNotificationHelper::notifyAll($title, $body, $parameter, $tokenArray, $route, $request->user_type);
        }

        Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'parameter' => $request->parameter,
            'user_type' => $request->user_type,
            'user_id' => 0,
            'route' => $route,
            'status' => 1,
        ]);

        return redirect()->route('admin.notification.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\AdminNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\AdminNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit PushNotification')) {
            abort(403);
        }
        return view('admin.notification.form')->with([
            'notification' => $notification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AdminNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
        $this->validate($request, [
            'title' => 'required|max:64',
            'message' => 'required',
            'parameter' => 'required',
            'route' => 'required',
        ]);
        $request->merge(['created_by' => 2]);
        $notification->update($request->all());
        //dd(DB::getQueryLog());
        return redirect()->route('admin.notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AdminNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete PushNotification')) {
            abort(403);
        }
        $notification->delete();
        return response()->json('success');
    }
}
