<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\State;
use App\Traits\TranslateTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CountryController extends Controller
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
        if ($request->ajax()) {
            $query = Country::select('countries.*')->orderBy('id', 'desc');

            return $datatables->eloquent($query)
                ->editColumn('status', function (Country $country) {

                    return ($country->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
            // ->editColumn('postcode_required', function (Country $country) {
            // return (($country->postcode_required == '1') ? '<td><span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">Required</span></td>' : '<span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger">Not Required</span>');
            //})

                ->editColumn('name', function (Country $country) {
                    return $country->name;
                })

                ->addColumn('action', function (Country $country) {
                    return '<a href="' . route('admin.country.edit', $country->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
                <a data-toggle="modal" href="#delete-country" data-href="' . route('admin.country.destroy', $country->id) . '" class="btn btn-sm btn-clean btn-icon country-delete" title="Delete"><i class="la la-trash"></i></a>

             ';

                })
                ->rawColumns(['action', 'status', 'name'])
                ->make(true);
        }

        return view('admin.country.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.form')->with('country', new Country());
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
            'iso_code_2' => 'required|min:2|max:2|alpha',
            'iso_code_3' => 'required|min:3|max:3|alpha',
            'currency_code' => 'required|max:3|alpha',
        ]);

        $name_ = [];
        // foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //     $name_[$key] = $this->translate($request->name,'en',$key);
        // }
        // $country = new Country();
        // $country->setTranslations('name',$name_);
        // $country->iso_code_2 = $request->iso_code_2;
        // $country->iso_code_3 = $request->iso_code_3;
        // $country->currency_code = $request->currency_code;
        // $country->phone_prefix = $request->phone_prefix;

        // $country->status= $request->status;
        // $country->save();
        Country::create($request->all());

        return redirect()->route('admin.country.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.country.form')->with([
            'country' => Country::whereId($country->id)->first(),

        ]);
        return view('admin.country.form')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $this->validate($request, [
            'name' => 'required',
            'iso_code_2' => 'required|min:2|max:2|alpha',
            'iso_code_3' => 'required|min:3|max:3|alpha',
            'currency_code' => 'required|max:3|alpha',
        ]);

        // if(strcmp($request->name, $country->name) !=0){
        //     $name_            = [];
        //  foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //      $name_[$key] = $this->translate($request->name,'en',$key);
        //  }
        //  $country->setTranslations('name',$name_);
        // }
        //   $country->iso_code_2 = $request->iso_code_2;
        //  $country->iso_code_3 = $request->iso_code_3;
        //  $country->currency_code = $request->currency_code;
        //  $country->phone_prefix = $request->phone_prefix;
        //  $country->status= $request->status;

        //  $country->save();
        $country->update($request->all());
        return redirect()->route('admin.country.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json('success');
    }

    /**
     * Get State Form Country.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */

    public function getState(Request $request)
    {

        $states = State::where('country_id', $request->country_id)->get();

        foreach ($states as $state) {

            $data['states'][] = array('id' => $state->id, 'name' => $state->getTranslation('name', 'en'));

        }
        if (count($data)) {
            return $data;
        } else {
            $data['states'] = array();
        }

        return $data;

    }

    public function state(Request $request)
    {
        $state = State::whereStatus(1)->where('country_id', $request->country_id)->get()->pluck('name', 'id');
        echo json_encode($state);
    }

}
