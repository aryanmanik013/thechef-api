<?php
//SAMAH
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\Day;
use App\Model\FoodSchedule;
use App\Model\Kitchen;
use App\Model\KitchenBanks;
use App\Model\KitchenDetails;
use App\Model\KitchenFood;
use App\Model\KitchenVideos;
use App\Model\PayoutGroup;
use App\Model\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MediaUploader;
use Plank\Mediable\Media;
use Yajra\Datatables\Datatables;

class KitchenController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Kitchen')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = Kitchen::with(['state', 'country'])->select('kitchens.*')->orderBy('id', 'DESC');
            return $datatables->eloquent($query)
                ->addColumn('image', function (Kitchen $kitchen) {
                    if (!empty($kitchen->getMedia('kitchen')->first())) {
                        $featured = $kitchen->getMedia('kitchen')->first();
                        return '<img width="150" height="100" src="' . $featured->getUrl() . '" />';
                    }
                })
                ->editColumn('name', function (Kitchen $kitchen) {
                    return strip_tags($kitchen->getTranslation('name', 'en'));
                })
                ->editColumn('approve_status', function (Kitchen $kitchen) {

                    if (!empty($kitchen->verification_request_date)) {
                        return ($kitchen->approval_status == 0 ? '<button type="button" data-id="' . $kitchen->id . '" data-toggle="modal" data-target="#approve-kitchen" class="btn btn-outline-success kitchen-approve">Approve</button>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Approved</span>');
                    } else {
                        return '--';
                    }

                })
                ->editColumn('status', function (Kitchen $kitchen) {
                    return ($kitchen->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->addColumn('country', function (Kitchen $kitchen) {
                    if (!empty($kitchen->country)) {
                        return $kitchen->country->getTranslation('name', 'en'); /*Get translated to english*/

                    }

                })
                ->addColumn('state', function (Kitchen $kitchen) {

                    if (!empty($kitchen->state)) {

                        return $kitchen->state->getTranslation('name', 'en'); /*Get translated to english*/
                    }

                })
                ->addColumn('action', function (Kitchen $kitchen) {
                    return
                        (auth()->user()->hasPermissionTo('Edit Kitchen') ? '<a href="' . route('admin.kitchen.edit', $kitchen->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
                ' : '') .
                        (auth()->user()->hasPermissionTo('Delete Kitchen') ? '<a data-toggle="modal" href="#delete_kitchen" data-href="' . route('admin.kitchen.destroy', $kitchen->id) . '" class="btn btn-sm btn-clean btn-icon kitchen-delete" title="Delete"><i class="la la-trash"></i></a>' : '')
                        .
                        (auth()->user()->hasPermissionTo('View Kitchen') ? '<a href="' . route('admin.kitchen.show', $kitchen->id) . '" class="btn btn-sm btn-clean btn-icon" title="View details"><i class="la la-eye"></i></a>' : '')
                        .
                        (auth()->user()->hasPermissionTo('View Kitchen') ? '<a href="' . route('admin.food-schedule.view', $kitchen->id) . '" class="btn btn-sm btn-clean btn-icon" title="Schedule Food"><i class="la la-calendar-week"></i></a>' : '');

                })
                ->rawColumns(['image', 'action', 'status', 'approve_status'])
                ->make(true);
        }
        return view('admin.kitchen.list')->with([
            'payout_groups' => PayoutGroup::where('type', 1)->where('status', 1)->get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Kitchen')) {
            abort(403);
        }
        return view('admin.kitchen.form')->with([
            'kitchen' => new Kitchen(),
            'kitchen_banks' => new KitchenBanks(),
            'kitchen_details' => new KitchenDetails(),
            'country' => Country::where('status', 1)->get()->pluck('name', 'id'),
            'payout_group' => PayoutGroup::where('type', 1)->where('status', 1)->get()->pluck('name', 'id'),
        ]);
    }
    /**
     * kitchen a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:64',
            'phone' => 'required|numeric',
            'email' => 'string|email|max:255',
            'password' => 'required|min:6|confirmed',
            'country_id' => 'integer',
            'postcode' => 'integer',
            'state_id' => 'integer',
            'city' => 'required|max:64',
            'image' => 'required',
            'address_line_1' => 'required',
            'contact_email' => 'string|email|max:255',
            'notification_email' => 'string|email|max:255',
        ]);
        $request->request->add(['password' => Hash::make($request->password), 'verification_status' => 1]);
        $request->merge(['approval_status' => 1, 'created_by' => 1]);
        $kitchen = Kitchen::create($request->all());
        if (!empty($request->file('image'))) {
            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('image'))
                ->useFilename($filename)
                ->toDirectory('kitchen/' . $kitchen->id)
                ->upload();
            $kitchen->attachMedia($media, ['kitchen']);
        }
        if (!empty($request->file('slider_images'))) {

            $slider = $request->file('slider_images');

            foreach ($slider as $key => $value) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediaslider = MediaUploader::fromSource($value)
                    ->useFilename($filename)
                    ->toDirectory('kitchen/' . $kitchen->id . '/slider')
                    ->upload();
                $kitchen->attachMedia($mediaslider, ['slider']);
            }
        }
        if (!empty($request->file('gallery_images'))) {

            $gallery = $request->file('gallery_images');

            foreach ($gallery as $key => $value) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediagallery = MediaUploader::fromSource($value)
                    ->useFilename($filename)
                    ->toDirectory('kitchen/' . $kitchen->id . '/gallery')
                    ->upload();
                $kitchen->attachMedia($mediagallery, ['gallery']);
            }
        }
        KitchenDetails::create([
            'kitchen_id' => $kitchen->id,
            'description' => $request->description,
            'specialities' => $request->specialities,
            'about' => $request->about,
            'order_policy' => $request->order_policy,
            'delivery_policy' => $request->delivery_policy,
            'payment_terms' => $request->payment_terms,

        ]);
        KitchenBanks::create([
            'kitchen_id' => $kitchen->id,
            'name' => $request->bank_name,
            'branch' => $request->branch,
            'payment_method' => $request->payment_method,
            'account_number' => $request->account_number,
            'ifsc' => $request->ifsc,
            'swift' => $request->swift,
            'email' => $request->bank_email,

        ]);
        $url = $request->url;
        $featured = $request->featured;
        if (isset($url)) {
            foreach ($url as $key => $value) {
                $kitchen->kitchenVideos()->create([
                    'url' => $url[$key],
                    'featured' => isset($featured[$key]) ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('admin.kitchen.index')->with('message', 'Kitchen Added Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\kitchenType  $kitchenType
     * @return \Illuminate\Http\Response
     */
    public function show(Kitchen $kitchen)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Kitchen')) {
            abort(403);
        }
        $featured = '';
        if (!empty($kitchen->getMedia('kitchen')->first())) {
            $featured = $kitchen->getMedia('kitchen')->first();
        }
        $schedule = [];

        $week = Day::get();

        foreach ($week as $day) {

            $schedule['day'][$day->id]['name'] = $day->name;
            $schedule['day'][$day->id]['id'] = $day->id;

            $schedule['day'][$day->id]['details'] = FoodSchedule::where('kitchen_id', $kitchen->id)->where('day', $day->id)->with(['scheduledFood.KitchenFood'])->get();

        }
        $proof = $kitchen->getMedia('proof');
        return view('admin.kitchen.detail')->with([
            'kitchen' => Kitchen::with('state', 'country', 'payoutGroup')->find($kitchen->id),
            'kitchen_details' => KitchenDetails::where('kitchen_id', $kitchen->id)->first(),
            'kitchen_banks' => KitchenBanks::where('kitchen_id', $kitchen->id)->first(),
            'kitchen_videos' => KitchenVideos::where('kitchen_id', $kitchen->id)->get(),
            'kitchen_foods' => KitchenFood::where('kitchen_id', $kitchen->id)->get(),
            'featured' => $featured,
            'proof' => $proof,
            'food_schedule' => $schedule,
            'kitchen_id' => $kitchen->id,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\kitchenType  $kitchenType
     * @return \Illuminate\Http\Response
     */
    public function edit(Kitchen $kitchen)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Kitchen')) {
            abort(403);
        }
        $kitchen_banks = KitchenBanks::where('kitchen_id', $kitchen->id)->first();
        $kitchen_details = KitchenDetails::where('kitchen_id', $kitchen->id)->first();
        $kitchen_videos = KitchenVideos::where('kitchen_id', $kitchen->id)->get();
        $featured = '';
        if (!empty($kitchen->getMedia('kitchen')->first())) {
            $featured = $kitchen->getMedia('kitchen')->first();
        }

        return view('admin.kitchen.form')->with([
            'kitchen' => Kitchen::with('kitchenBanks', 'kitchenDetails')->whereId($kitchen->id)->first(),
            'featured' => $featured,
            'kitchen_banks' => $kitchen_banks,
            'kitchen_details' => $kitchen_details,
            'kitchen_videos' => $kitchen_videos,
            'country' => Country::where('status', 1)->get()->pluck('name', 'id'),
            'states' => State::where('country_id', $kitchen->country_id)->where('status', 1)->get()->pluck('name', 'id'),
            'payout_group' => PayoutGroup::where('type', 1)->where('status', 1)->get()->pluck('name', 'id'),
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\kitchenType  $kitchenType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kitchen $kitchen)
    {
        $this->validate($request, [
            'name' => 'required|max:64',
            'phone' => 'required|numeric',
            'email' => 'string|email|max:255',
            'country_id' => 'integer',
            'state_id' => 'integer',
            'city' => 'required|max:64',
            'address_line_1' => 'required',
            'contact_email' => 'string|email|max:255',
            'notification_email' => 'string|email|max:255',
        ]);
        $request->request->add(['password' => Hash::make($request->phone)]);
        // $request->merge([ 'approval_status' => 1]);
        $kitchen->update($request->all());
        $featured = $kitchen->getMedia('kitchen')->first();
        if (!empty($request->file('image'))) {
            if (isset($featured)) {
                $old_image = Media::whereId($featured->id)->first();
                if ($old_image) {
                    $old_image->delete();
                }
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('image'))
                ->useFilename($filename)
                ->toDirectory('kitchen/' . $kitchen->id)
                ->upload();
            $kitchen->attachMedia($media, ['kitchen']);
        }
        if (!empty($request->file('slider_images'))) {

            $slider = $request->file('slider_images');

            foreach ($slider as $key => $value) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediaslider = MediaUploader::fromSource($value)
                    ->useFilename($filename)
                    ->toDirectory('kitchen/' . $kitchen->id . '/slider')
                    ->upload();
                $kitchen->attachMedia($mediaslider, ['slider']);
            }
        }
        if (!empty($request->file('gallery_images'))) {
            $gallery = $request->file('gallery_images');

            foreach ($gallery as $key => $value) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediagallery = MediaUploader::fromSource($value)
                    ->useFilename($filename)
                    ->toDirectory('kitchen/' . $kitchen->id . '/gallery')
                    ->upload();
                $kitchen->attachMedia($mediagallery, ['gallery']);
            }
        }
        KitchenDetails::where('kitchen_id', $kitchen->id)->delete();
        KitchenBanks::where('kitchen_id', $kitchen->id)->delete();
        KitchenDetails::create([
            'kitchen_id' => $kitchen->id,
            'description' => $request->description,
            'specialities' => $request->specialities,
            'about' => $request->about,
            'order_policy' => $request->order_policy,
            'delivery_policy' => $request->delivery_policy,
            'payment_terms' => $request->payment_terms,

        ]);
        KitchenBanks::create([
            'kitchen_id' => $kitchen->id,
            'bank_name' => $request->bank_name,
            'branch' => $request->branch,
            'payment_method' => $request->payment_method,
            'account_number' => $request->account_number,
            'ifsc' => $request->ifsc,
            'swift' => $request->swift,

        ]);
        $kitchen->kitchenVideos()->delete();
        $url = $request->url;
        $featured = $request->featured;
        if (isset($url)) {
            foreach ($url as $key => $value) {
                $kitchen->kitchenVideos()->create([
                    'url' => $url[$key],
                    'featured' => isset($featured[$key]) ? 1 : 0,
                ]);
            }
        }
        return redirect()->route('admin.kitchen.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\kitchenType  $kitchenType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kitchen $kitchen)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Kitchen')) {
            abort(403);
        }
        $food = KitchenFood::where('kitchen_id', $kitchen->id)->get();

        if (!empty($food && $food->count())) {
            return response()->json(['status' => 'fail']);

        } else {

            $kitchen->delete();
            return response()->json(['status' => 'success']);
        }

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
    /**
     * Remove the album image.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */

    public function imageDelete(Request $request)
    {
        $image = Media::whereId($request->code)->first();
        if ($image->delete()) {
            echo 1;
        } else {
            echo 0;
        }

    }

    public function imageKitchenGalleryDelete(Request $request)
    {
        $image = Media::whereId($request->id)->first();

        if ($image->delete()) {
            echo 1;
        } else {
            echo 0;
        }

    }
    public function imageKitchenSliderDelete(Request $request)
    {
        $image = Media::whereId($request->id)->first();

        if ($image->delete()) {
            echo 1;
        } else {
            echo 0;
        }

    }
    /**
     * Change approve status of the Kitchen.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */

    public function kitchenApprove(Kitchen $kitchen, Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Kitchen')) {
            abort(403);
        }
        $kitchen = Kitchen::find($request->id);

        $kitchen->approval_status = 1;
        $kitchen->payout_group_id = $request->payout_group_id;
        $kitchen->save();
        return response()->json(['status' => 'success']);

    }

}
