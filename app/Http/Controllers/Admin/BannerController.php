<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\Information;
use App\Model\Kitchen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MediaUploader;
use Plank\Mediable\Media;
use Yajra\Datatables\Datatables;

class BannerController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Banner')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = Banner::select('banners.*')->orderBy('id', 'DESC');
            return $datatables->eloquent($query)

                ->addColumn('image', function (Banner $banner) {
                    if (!empty($banner->getMedia('banner')->first())) {
                        $featured = $banner->getMedia('banner')->first();
                        return '<img width="150" height="90" src="' . $featured->getUrl() . '" />';
                    }

                })

                ->editColumn('status', function (Banner $banner) {

                    return ($banner->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');

                })
                ->addColumn('action', function (Banner $banner) {
                    return (auth()->user()->hasPermissionTo('Edit Banner') ? '<a href="' . route('admin.banner.edit', $banner->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete Banner') ? '<a  data-toggle="modal" href="#delete_banner" data-href="' . route('admin.banner.destroy', $banner->id) . '" class="btn btn-sm btn-clean btn-icon banner-delete" title="Delete"><i class="la la-trash"></i></a>' : '');
                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }
        return view('admin.banner.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Banner')) {
            abort(403);
        }
        return view('admin.banner.form')->with([
            'banner' => new banner(),
            'information' => Information::where('status', 1)->get(),
            'kitchens' => Kitchen::where('status', 1)->get(),
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
            'activity' => 'required|max:64',
            'parameter' => 'required',
            'sort_order' => 'integer',
            'image' => 'required',
            'status' => 'required|boolean',

        ]);

        $banner = banner::create($request->all());
        if (!empty($request->file('image'))) {
            $time = time();
            $filename = 'THECHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('image'))
                ->useFilename($filename)

                ->toDirectory('banner')
                ->upload();
            $banner->attachMedia($media, ['banner']);
        }

        return redirect()->route('admin.banner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(banner $banner)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Banner')) {
            abort(403);
        }
        return view('admin.banner.form')->with([
            'banner' => $banner,
            'information' => Information::where('status', 1)->get(),
            'kitchens' => Kitchen::where('status', 1)->get(),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, banner $banner)
    {
        //dd($request->all());
        $this->validate($request, [
            'activity' => 'required|max:64',
            'parameter' => 'required',
            'sort_order' => 'integer',
            'status' => 'required|boolean',
        ]);

        $banner->update($request->all());
        $featured = $banner->getMedia('banner')->first();
        if (!empty($request->file('image'))) {
            $old_image = Media::whereId($featured->id)->first();
            if ($old_image) {
                $old_image->delete();
            }
            $time = time();
            $filename = 'THECHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('image'))
                ->useFilename($filename)

                ->toDirectory('banner')
                ->upload();
            $banner->attachMedia($media, ['banner']);
        }
        //dd(DB::getQueryLog());
        return redirect()->route('admin.banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(banner $banner)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Banner')) {
            abort(403);
        }
        $banner->delete();
        return response()->json('success');

    }
}
