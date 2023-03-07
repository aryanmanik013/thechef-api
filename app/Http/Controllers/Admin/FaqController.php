<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use App\Traits\TranslateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class FaqController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View FAQ')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = Faq::select('faqs.*');

            return $datatables->eloquent($query)
                ->editColumn('status', function (Faq $faq) {

                    return ($faq->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->editColumn('question', function (Faq $faq) {
                    return $faq->question;
                })

                ->editColumn('answer', function (Faq $faq) {
                    return strip_tags($faq->getTranslation('answer', 'en'));
                })

                ->addColumn('action', function (Faq $faq) {
                    return (auth()->user()->hasPermissionTo('Edit FAQ') ? '<a href="' . route('admin.faq.edit', $faq->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete FAQ') ? '<a data-toggle="modal" href="#delete-faq" data-href="' . route('admin.faq.destroy', $faq->id) . '" class="btn btn-sm btn-clean btn-icon faq-delete" title="Delete"><i class="la la-trash"></i></a>' : '');

                })
                ->rawColumns(['action', 'status', 'answer', 'question'])
                ->make(true);
        }
        return view('admin.faq.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create FAQ')) {
            abort(403);
        }
        return view('admin.faq.form')->with([
            'faq' => new Faq(),
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
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',
            'sort_order' => 'required',
        ]);

        $quest_ = [];
        $ans_ = [];
        // dd($this->translate('hello','en','es'));
        // dd(LaravelLocalization::getSupportedLocales());
        // foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //     $quest_[$key] = $this->translate($request->question,'en',$key);
        //      $ans_[$key] = $this->translate($request->answer,'en',$key,'html');
        // }

        // $fa = new Faq();
        // $fa->setTranslations('question',$quest_);
        // $fa->setTranslations('answer',$ans_);
        // $fa->status = $request->status;
        // $fa->sort_order = $request->sort_order;
        // $fa->save();
        $faq = Faq::create($request->all());
        return redirect()->route('admin.faq.index')->with('message', ' FAQ Added Successfully..');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit FAQ')) {
            abort(403);
        }
        return view('admin.faq.form')->with([
            'faq' => Faq::whereId($faq->id)->first(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        //dd($request->all());
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
            //'status'  => 'required',
            //'sort_order'  => 'required'
        ]);
        $quest_ = [];
        $ans_ = [];
        // foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //     $quest_[$key] = $this->translate($request->question,'en',$key);
        //      $ans_[$key] = $this->translate($request->answer,'en',$key,'html');
        // }

        // $faq->setTranslations('question',$quest_);
        // $faq->setTranslations('answer',$ans_);
        // $faq->status = $request->status;
        // $faq->sort_order = $request->sort_order;
        // $faq->save();
        $faq->update($request->all());
        return redirect()->route('admin.faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete FAQ')) {
            abort(403);
        }
        $faq->delete();
        return response()->json('success');
    }
}
