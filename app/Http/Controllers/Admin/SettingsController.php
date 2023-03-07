<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class SettingsController extends Controller
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

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Settings')) {
            abort(403);
        }

        if ($request->ajax()) {
            $query = Settings::orderBy('id', 'desc')->select('settings.*');
            return $datatables->eloquent($query)

                ->addColumn('action', function (Settings $Settings) {
                    return (auth()->user()->hasPermissionTo('Edit Settings') ? '<a href="' . route('admin.settings.edit', $Settings->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              ' : '');
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.settings.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Settings')) {
            abort(403);
        }
        return view('admin.settings.form')->with([
            'settings' => new Settings(),
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
            'value' => 'required',

        ]);

        Settings::create($request->all());

        return redirect()->route('admin.settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Settings $Settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $Settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Settings $Settings
     * @return \Illuminate\Http\Response
     */
    public function edit($Settings)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Settings')) {
            abort(403);
        }
        return view('admin.settings.form')->with(['settings' => Settings::find($Settings),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Settings  $Settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Settings)
    {

        $this->validate($request, [
            // 'title' => 'required|max:64',
            'value' => 'required',

        ]);
        $Settings = Settings::find($Settings);
        $Settings->update($request->all());

        return redirect()->route('admin.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Settings $Settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $Settings)
    {
        //
    }
}
