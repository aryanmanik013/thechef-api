<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FoodCategory;
use App\Traits\TranslateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MediaUploader;
use Plank\Mediable\Media;
use Yajra\Datatables\Datatables;

class FoodCategoryController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Category')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = FoodCategory::select('food_categories.*');

            return $datatables->eloquent($query)

                ->addColumn('parent', function (FoodCategory $foodCategory) {
                    return (!empty($foodCategory->parent) ? '' . $foodCategory->parent->name . '' : '-');
                })
                ->editColumn('status', function (FoodCategory $foodCategory) {

                    return ($foodCategory->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
            // ->addColumn('name', function (FoodCategory $foodCategory) {
            //     return $foodCategory->getTranslation('name','en');
            // })

                ->addColumn('image', function (FoodCategory $foodCategory) {
                    if (!empty($foodCategory->getMedia('category')->first())) {
                        $featured = $foodCategory->getMedia('category')->first();
                        return '<img width="150" height="90" src="' . $featured->getUrl() . '" />';
                    }

                })
                ->addColumn('action', function (FoodCategory $foodCategory) {
                    return (auth()->user()->hasPermissionTo('Edit Category') ? '<a href="' . route('admin.food_category.edit', $foodCategory->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete Category') ? '<a data-toggle="modal" href="#delete-category" data-href="' . route('admin.food_category.destroy', $foodCategory->id) . '" class="btn btn-sm btn-clean btn-icon category-delete" title="Delete"><i class="la la-trash"></i></a>' : '');

                })
                ->rawColumns(['action', 'status', 'name', 'description', 'image'])
                ->make(true);
        }
        return view('admin.food_category.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Category')) {
            abort(403);
        }
        return view('admin.food_category.form')->with([
            'foodcategory' => new FoodCategory(),
            'categories' => FoodCategory::where('status', 1)->orderBy('sort_order', 'asc')->get(),
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
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'required',
            'sort_order' => 'required',
        ]);

        // foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //     $quest_[$key] = $this->translate($request->name,'en',$key);
        //      $ans_[$key] = $this->translate($request->description,'en',$key,'html');
        // }

        if ($request->popular == 'on') {
            $request->merge(['popular' => 1]);
        }

        $foodcategory = FoodCategory::create($request->all(), FoodCategory::find($request->parent_id));
        if (!empty($request->file('image'))) {
            $time = time();
            $filename = 'THECHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('image'))
                ->useFilename($filename)

                ->toDirectory('category')
                ->upload();
            $foodcategory->attachMedia($media, ['category']);
        }
        return redirect()->route('admin.food_category.index')->with('message', ' Category Added Successfully..');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FoodCategory  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCategory $foodCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FoodCategory  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FoodCategory $foodCategory)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Category')) {
            abort(403);
        }
        return view('admin.food_category.form')->with([
            'foodcategory' => FoodCategory::whereId($foodCategory->id)->first(),
            'categories' => FoodCategory::where('status', 1)->orderBy('sort_order', 'asc')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FoodCategory  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodCategory $foodCategory)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'sort_order' => 'required',
        ]);

        // foreach(LaravelLocalization::getSupportedLocales() as $key => $language){
        //     $quest_[$key] = $this->translate($request->name,'en',$key);
        //      $ans_[$key] = $this->translate($request->description,'en',$key,'html');
        // }

        if ($request->popular == 'on') {
            $request->merge(['popular' => 1]);
        } else {
            $request->merge(['popular' => 0]);
        }

        $foodCategory->update($request->all());

        if ($request->parent_id != 0) {
            $foodCategory->appendToNode(FoodCategory::find($request->parent_id))->save();
        } else {
            $foodCategory->saveAsRoot();
        }
        $featured = $foodCategory->getMedia('category')->first();
        if (!empty($request->file('image'))) {
            $old_image = Media::whereId($featured->id)->first();
            if ($old_image) {
                $old_image->delete();
            }
            $time = time();
            $filename = 'THECHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('image'))
                ->useFilename($filename)

                ->toDirectory('category')
                ->upload();
            $foodCategory->attachMedia($media, ['category']);
        }
        return redirect()->route('admin.food_category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FoodCategory  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodCategory $foodCategory)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Category')) {
            abort(403);
        }
        $foodCategory->delete();
        return response()->json('success');
    }
}
