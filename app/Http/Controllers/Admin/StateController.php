<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\State;
use App\Traits\TranslateTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class StateController extends Controller
{
    use TranslateTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->init();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Datatables $datatables)
    {
//         if (!auth()->user()->hasPermissionTo('View States')) {
        //             abort(403);
        //         }
        if ($request->ajax()) {
            $query = State::with(['country'])->where(function ($query) use ($request) {

                if (isset($request->country)) {
                    $query->where('country_id', $request->country);
                }
            })->select('states.*')->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (State $state) {

                    return ($state->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })

                ->editColumn('name', function (State $state) {
                    return $state->name;
                })
                ->editColumn('country_id', function (State $state) {
                    return $state->country->name;
                })

                ->addColumn('action', function (State $state) {

                    return '<a href="' . route('admin.state.edit', $state->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
             <a data-toggle="modal" href="#delete-state" data-href="' . route('admin.state.destroy', $state->id) . '" class="btn btn-sm btn-clean btn-icon state-delete" title="Delete"><i class="la la-trash"></i></a>
             ';
                })

                ->rawColumns(['status', 'name', 'country_id', 'action'])
                ->make(true);
        }
        $country = Country::where('status', 1)->get()->pluck('name', 'id');
        return view('admin.state.list')->with(['countries' => $country]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//         if (!auth()->user()->hasPermissionTo('Create States')) {
        //             abort(403);
        //         }
        return view('admin.state.form')->with(['state' => new State(), 'country' => Country::get()->pluck('name', 'id'),
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
            'name' => 'required',
            'country_id' => 'required|not_in:none',
        ]);

        // $name_            = [];
        // foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //     $name_[$key] = $this->translate($request->name,'en',$key);
        // }
        // $state = new State();
        // $state->setTranslations('name',$name_);
        // $state->country_id = $request->country_id;
        // $state->code = $request->code;
        // $state->status= $request->status;
        // $state->save();
        $state = State::create($request->all());
        return redirect()->route('admin.state.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
//         if (!auth()->user()->hasPermissionTo('Edit States')) {
        //             abort(403);
        //         }
        return view('admin.state.form')->with(['state' => State::whereId($state->id)->first(), 'country' => Country::get()->pluck('name', 'id'),
        ]);
        //return view('admin.country.form')->with('country',$country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $this->validate($request, [
            'name' => 'required',
            'country_id' => 'required',
        ]);
        // dd($request);
        //  $name_            = [];
        // if(strcmp($request->name, $state->name) !=0){

        //  foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //      $name_[$key] = $this->translate($request->name,'en',$key);
        //   }
        // }
        // $state->setTranslations('name',$name_);
        // $state->country_id = $request->country_id;
        // $state->code = $request->code;
        //  $state->status= $request->status;
        // $state->save();
        $state->update($request->all());
        return redirect()->route('admin.state.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
//         if (!auth()->user()->hasPermissionTo('Delete States')) {
        //             abort(403);
        //         }
        $state->delete();
        return response()->json('success');
    }
}
