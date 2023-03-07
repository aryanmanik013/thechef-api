<?php

/**
 *
 *
 * Author :Ananthu
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class InformationController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Information')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = Information::select('information.*');
            return $datatables->eloquent($query)
                ->addColumn('action', function (Information $information) {
                    return (auth()->user()->hasPermissionTo('Edit Information') ? '<a href="' . route('admin.information.edit', $information->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              ' : '');

                })
                ->editColumn('status', function (Information $information) {
                    return ($information->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->editColumn('type', function (Information $information) {
                    return ($information->type == 1 ? 'Store' : ($information->type == 2 ? 'Delivery Boy' : ($information->type == 3 ? 'Customer' : '')));
                })
                ->editColumn('title', function (Information $information) {
                    return strip_tags($information->getTranslation('title', 'en'));
                })
                ->editColumn('short_description', function (Information $information) {
                    return strip_tags($information->getTranslation('short_description', 'en'));
                })
                ->editColumn('description', function (Information $information) {
                    return strip_tags($information->getTranslation('description', 'en'));
                })
                ->rawColumns(['action', 'status', 'type'])
                ->make(true);
        }
        return view('admin.information.list');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Information')) {
            abort(403);
        }
        return view('admin.information.form')->with([
            'information' => new Information(),
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
            'title' => 'required|max:64',
            'short_description' => 'required',
            'description' => 'required',
            'sort_order' => 'integer',
            'type' => 'integer',
            'status' => 'required|boolean',
        ]);
        Information::create($request->all());
        return redirect()->route('admin.information.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Information')) {
            abort(403);
        }
        return view('admin.information.form')->with([
            'information' => $information,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        $this->validate($request, [
            'title' => 'required|max:64',
            'short_description' => 'required',
            'description' => 'required',
            'sort_order' => 'integer',
            'type' => 'integer',
            'status' => 'required|boolean',
        ]);
        $information->update($request->all());
        return redirect()->route('admin.information.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Information')) {
            abort(403);
        }
        $information->delete();
        return response()->json('success');
    }
}
