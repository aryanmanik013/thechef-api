<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\DeliveryPartner;
use App\Model\DeliveryPartnerBank;
use App\Model\PayoutGroup;
use App\Model\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MediaUploader;
use Plank\Mediable\Media;
use Yajra\Datatables\Datatables;

class DeliveryPartnerController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View DeliveryPartner')) {
            abort(403);
        }
        if ($request->ajax()) {
            $query = DeliveryPartner::select('delivery_partners.*')->orderBy('id', 'DESC');

            return $datatables->eloquent($query)

                ->editColumn('status', function (DeliveryPartner $deliveryPartner) {

                    return ($deliveryPartner->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');

                })
                ->addColumn('action', function (DeliveryPartner $deliveryPartner) {
                    return (auth()->user()->hasPermissionTo('Edit DeliveryPartner') ? '<a href="' . route('admin.delivery-partner.edit', $deliveryPartner->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete DeliveryPartner') ? '<a  data-toggle="modal" href="#delete_delivery_partner" data-href="' . route('admin.delivery-partner.destroy', $deliveryPartner->id) . '" class="btn btn-sm btn-clean btn-icon delivery_partner_delete" title="Delete"><i class="la la-trash"></i></a>' : '')
                        . (auth()->user()->hasPermissionTo('View DeliveryPartner') ? '<a href="' . route('admin.delivery-partner.show', $deliveryPartner->id) . '" class="btn btn-sm btn-clean btn-icon" title="View details"><i class="la la-eye"></i></a>' : '');

                })

                ->addColumn('approve_status', function (DeliveryPartner $deliveryPartner) {

                    if (!empty($deliveryPartner->approval_request_date)) {
                        return ($deliveryPartner->approval_status == 0 ? '<button type="button" data-id="' . $deliveryPartner->id . '" data-toggle="modal" data-target="#approve-deliveryPartner" class="btn btn-outline-success deliveryPartner-approve">Approve</button>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Approved</span>');
                    } else {
                        return '--';
                    }

                })
                ->rawColumns(['action', 'status', 'image', 'approve_status'])
                ->make(true);
        }
        return view('admin.delivery_partner.list')->with([

            'payout_groups' => PayoutGroup::where('type', 2)->where('status', 1)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create DeliveryPartner')) {
            abort(403);
        }
        return view('admin.delivery_partner.form')->with([
            'delivery_partner' => new DeliveryPartner(),
            'country' => Country::where('status', 1)->get()->pluck('name', 'id'),
            'payout_groups' => PayoutGroup::where('type', 2)->where('status', 1)->get(),
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

        $deliveryPartner = DeliveryPartner::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender_id' => 1,
            'phone' => $request->phone,
            'kyc_id_number' => $request->kyc_id_number,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'landmark' => $request->landmark,
            'street_name' => $request->street_name,
            'city' => $request->city,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'status' => $request->status,
            'payout_group_id' => $request->payout_group_id,
        ]);

        if (!empty($request->delivery_partner_bank)) {

            foreach ($request->delivery_partner_bank as $delivery_partner_bank) {

                $bank = DeliveryPartnerBank::create([
                    'delivery_partner_id' => $deliveryPartner->id,
                    'payment_method' => $delivery_partner_bank['payment_method'],
                    'bank_name' => $delivery_partner_bank['bank_name'],
                    'branch' => $delivery_partner_bank['branch'],
                    'account_number' => $delivery_partner_bank['account_number'],
                    'ifsc' => $delivery_partner_bank['ifsc'],
                    'swift' => $delivery_partner_bank['swift'],
                    'branch' => $delivery_partner_bank['branch'],
                    'email' => $delivery_partner_bank['email'],
                ]);
            }
        }
        if (!empty($request->file('proof_image'))) {

            /*  $temp = tempnam(sys_get_temp_dir(),'image');
            rename($temp, $temp = $temp . '.jpg');
            $image = Image::make($request->file('featured_image'))
            ->resize(300, null, function($constraint){ $constraint->aspectRatio(); })
            ->orientate()
            ->save($temp);  */

            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('proof_image'))
                ->useFilename($filename)
                ->toDirectory('delivery_partner_proof/' . $deliveryPartner->id)
                ->upload();

            $deliveryPartner->attachMedia($media, ['proof']);
        }

        if (!empty($request->file('profile_image'))) {

            /*  $temp = tempnam(sys_get_temp_dir(),'image');
            rename($temp, $temp = $temp . '.jpg');
            $image = Image::make($request->file('featured_image'))
            ->resize(300, null, function($constraint){ $constraint->aspectRatio(); })
            ->orientate()
            ->save($temp);  */

            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('profile_image'))
                ->useFilename($filename)
                ->toDirectory('delivery_partner/' . $deliveryPartner->id)
                ->upload();

            $deliveryPartner->attachMedia($media, ['profile']);
        }

        return redirect()->route('admin.delivery-partner.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DeliveryPartner  $deliveryPartner
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryPartner $deliveryPartner)
    {
        $proof = "";
        if (!empty($deliveryPartner->getMedia('proof')->first())) {
            $proof = $deliveryPartner->getMedia('proof')->first();
        }

        return view('admin.delivery_partner.detail')->with([
            'delivery_partner' => DeliveryPartner::with(['bank', 'payoutGroup'])->whereId($deliveryPartner->id)->first(),
            'proof' => $proof,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DeliveryPartner  $deliveryPartner
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryPartner $deliveryPartner)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit DeliveryPartner')) {
            abort(403);
        }
        $proof = "";
        $profile = "";

        if (!empty($deliveryPartner->getMedia('proof')->first())) {
            $proof = $deliveryPartner->getMedia('proof')->first();
        }
        if (!empty($deliveryPartner->getMedia('profile')->first())) {
            $profile = $deliveryPartner->getMedia('profile')->first();
        }

        return view('admin.delivery_partner.form')->with([
            'delivery_partner' => DeliveryPartner::with('bank')->whereId($deliveryPartner->id)->first(),
            'proof' => $proof,
            'country' => Country::where('status', 1)->get()->pluck('name', 'id'),
            'states' => State::where('status', 1)->get()->pluck('name', 'id'),
            'profile' => $profile,
            'payout_groups' => PayoutGroup::where('type', 2)->where('status', 1)->get(),

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DeliveryPartner  $deliveryPartner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryPartner $deliveryPartner)
    {

        $request->merge(['gender_id' => 1]);

        $deliveryPartner->fill($request->only(['name', 'email', 'payout_group_id', 'gender_id', 'phone', 'kyc_id_number', 'address_line_1', 'address_line_2', 'landmark', 'street_name', 'city', 'state_id', 'country_id', 'status']));
        $deliveryPartner->save();
        if (!empty($request->delivery_partner_bank)) {
            DeliveryPartnerBank::where('delivery_partner_id', $deliveryPartner->id)->delete();

            foreach ($request->delivery_partner_bank as $delivery_partner_bank) {

                DeliveryPartnerBank::create([
                    'delivery_partner_id' => $deliveryPartner->id,
                    'payment_method' => $delivery_partner_bank['payment_method'],
                    'bank_name' => $delivery_partner_bank['bank_name'],
                    'branch' => $delivery_partner_bank['branch'],
                    'account_number' => $delivery_partner_bank['account_number'],
                    'ifsc' => $delivery_partner_bank['ifsc'],
                    'swift' => $delivery_partner_bank['swift'],
                    'branch' => $delivery_partner_bank['branch'],
                    'email' => $delivery_partner_bank['email'],

                ]);
            }

        }

        if (!empty($request->file('proof_image'))) {

            $old_proof = Media::whereId($request->old_image)->first();
            if ($old_proof) {
                $old_proof->delete();
            }

            /*  $temp = tempnam(sys_get_temp_dir(),'image');
            rename($temp, $temp = $temp . '.jpg');
            $image = Image::make($request->file('featured_image'))
            ->resize(300, null, function($constraint){ $constraint->aspectRatio(); })
            ->orientate()
            ->save($temp);  */

            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('proof_image'))
                ->useFilename($filename)
                ->toDirectory('delivery_partner_proof/' . $deliveryPartner->id)
                ->upload();

            $deliveryPartner->attachMedia($media, ['proof']);
        }
        if (!empty($request->file('profile_image'))) {

            $old_profile = Media::whereId($request->old_image1)->first();
            if ($old_profile) {
                $old_profile->delete();
            }

            /*  $temp = tempnam(sys_get_temp_dir(),'image');
            rename($temp, $temp = $temp . '.jpg');
            $image = Image::make($request->file('featured_image'))
            ->resize(300, null, function($constraint){ $constraint->aspectRatio(); })
            ->orientate()
            ->save($temp);  */

            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('profile_image'))
                ->useFilename($filename)
                ->toDirectory('delivery_partner/' . $deliveryPartner->id)
                ->upload();

            $deliveryPartner->attachMedia($media, ['profile']);
        }

        return redirect()->route('admin.delivery-partner.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DeliveryPartner  $deliveryPartner
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryPartner $deliveryPartner)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete DeliveryPartner')) {
            abort(403);
        }
        $deliveryPartner->delete();
        return response()->json('success');
    }

    /**
     * Change approve status of the deliveryPartner.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */

    public function deliveryPartnerApprove(DeliveryPartner $deliveryPartner, Request $request)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit DeliveryPartner')) {
            abort(403);
        }
        $deliveryPartner = DeliveryPartner::find($request->id);

        $deliveryPartner->approval_status = 1;
        $deliveryPartner->payout_group_id = $request->payout_group_id;
        $deliveryPartner->save();
        return response()->json(['status' => 'success']);

    }
}
