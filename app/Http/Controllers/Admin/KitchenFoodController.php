<?php

/**
 *
 *
 * Author :Ananthu
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FoodCategory;
use App\Model\Kitchen;
use App\Model\KitchenFood;
use App\Model\KitchenFoodCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use MediaUploader;
use Plank\Mediable\Media;
use Yajra\Datatables\Datatables;

class KitchenFoodController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Food')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = KitchenFood::with(['kitchen'])->select('kitchen_food.*')->orderBy('id', 'DESC');

            return $datatables->eloquent($query)

                ->addColumn('image', function (KitchenFood $KitchenFood) {

                    if (!empty($KitchenFood->getMedia('gallery')->first())) {
                        $gallery = $KitchenFood->getMedia('gallery')->first();
                        return '<img width="50" height="50" src="' . $gallery->getUrl() . '" />';
                    }

                })
            // ->addColumn('kitchen', function (KitchenFood $KitchenFood) {

            //         return $KitchenFood->kitchen->getTranslation('name','en');

            //   })
                ->addColumn('price', function (KitchenFood $KitchenFood) {

                    return number_format($KitchenFood->price, 2);

                })
                ->editColumn('status', function (KitchenFood $KitchenFood) {

                    return ($KitchenFood->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');

                })

                ->addColumn('action', function (KitchenFood $KitchenFood) {

                    return (auth()->user()->hasPermissionTo('Edit Food') ? '<a href="' . route('admin.kitchen-food.edit', $KitchenFood->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit" ></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete Food') ? '<a data-toggle="modal" href="#delete-kitchen_food" data-href="' . route('admin.kitchen-food.destroy', $KitchenFood->id) . '" class="btn btn-sm btn-clean btn-icon kitchen_food-delete" title="Delete"><i class="flaticon-delete" ></i></a>' : '');

                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }
        return view('admin.kitchen_food.list');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Food')) {
            abort(403);
        }
        return view('admin.kitchen_food.form')->with([

            'categories' => FoodCategory::where('status', 1)->orderBy('sort_order', 'ASC')->get(),
            'kitchens' => Kitchen::where('status', 1)->get(),
            'kitchen_food' => new KitchenFood(),
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

            'kitchen_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',

        ]);

        $kitchenFood = KitchenFood::create($request->all());

        /* Add food Category*/

        $category_id = $request->category_id;

        foreach ($category_id as $id) {

            KitchenFoodCategory::create([
                'kitchen_food_id' => $kitchenFood->id,
                'food_category_id' => $id,

            ]);
        }

        if (!empty($request->file('gallery_images'))) {

            $gallery = $request->file('gallery_images');

            foreach ($gallery as $key => $value) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediagallery = MediaUploader::fromSource($value)
                    ->useFilename($filename)
                    ->toDirectory('kitchen_food/' . $kitchenFood->id . '/gallery')
                    ->upload();
                $kitchenFood->attachMedia($mediagallery, ['gallery']);
            }
        }

        return redirect()->route('admin.kitchen-food.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\KitchenFood  $kitchenFood
     * @return \Illuminate\Http\Response
     */
    public function show(KitchenFood $kitchenFood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\KitchenFood  $kitchenFood
     * @return \Illuminate\Http\Response
     */
    public function edit(KitchenFood $kitchenFood)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Food')) {
            abort(403);
        }
        return view('admin.kitchen_food.form')->with([

            'categories' => FoodCategory::where('status', 1)->orderBy('sort_order', 'ASC')->get(),
            'kitchens' => Kitchen::where('status', 1)->get(),
            'kitchen_food_categories' => KitchenFoodCategory::where('kitchen_food_id', $kitchenFood->id)->get()->pluck('food_category_id')->toArray(),
            'kitchen_food' => KitchenFood::with('kitchen', 'categories')->whereId($kitchenFood->id)->first(),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\KitchenFood  $kitchenFood
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KitchenFood $kitchenFood)
    {
        $this->validate($request, [
            'kitchen_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',

        ]);

        $kitchenFood->update($request->all());

        /* Add food Category*/

        KitchenFoodCategory::where('kitchen_food_id', $kitchenFood->id)->delete();

        $category_id = $request->category_id;

        foreach ($category_id as $id) {

            KitchenFoodCategory::create([
                'kitchen_food_id' => $kitchenFood->id,
                'food_category_id' => $id,

            ]);
        }

        if (!empty($request->file('gallery_images'))) {

            $gallery = $request->file('gallery_images');

            foreach ($gallery as $key => $value) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediagallery = MediaUploader::fromSource($value)
                    ->useFilename($filename)
                    ->toDirectory('kitchen_food/' . $kitchenFood->id . '/gallery')
                    ->upload();
                $kitchenFood->attachMedia($mediagallery, ['gallery']);
            }
        }

        return redirect()->route('admin.kitchen-food.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\KitchenFood  $kitchenFood
     * @return \Illuminate\Http\Response
     */
    public function destroy(KitchenFood $kitchenFood)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Food')) {
            abort(403);
        }
        $kitchenFood->delete();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified image from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */

    public function imageGalleryDelete(Request $request)
    {
        $image = Media::whereId($request->id)->first();

        if ($image->delete()) {
            echo 1;
        } else {
            echo 0;
        }

    }
}
