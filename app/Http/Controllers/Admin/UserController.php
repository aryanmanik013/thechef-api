<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MediaUploader;
use Plank\Mediable\Media;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class UserController extends Controller
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
        //
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View Users')) {
            abort(403);
        }
        if ($request->ajax()) {

            $query = User::select('users.*')->orderBy('id', 'desc');
            return $datatables->eloquent($query)

                ->addColumn('phone', function (User $user) {
                    //return (!empty($customer->phone_prefix)) ? '+'.$customer->phone_prefix.' '.$customer->phone : ' ';
                    return (!empty($user->phone)) ? $user->phone : ' ';
                })
                ->addColumn('status', function (User $user) {
                    return ($user->status == 0 ? '<span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span>' : '<span class="label label-lg font-weight-bold label-light-success label-inline">Enabled</span>');
                })
                ->addColumn('action', function (User $user) {
                    return (auth()->user()->hasPermissionTo('Edit Users') ? '<a href="' . route('admin.user.edit', $user->id) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"><i class="la la-edit"></i></a>
              ' : '') . (auth()->user()->hasPermissionTo('Delete Users') ? '<a data-toggle="modal" href="#user-delete" data-href="' . route('admin.user.destroy', $user->id) . '" class="btn btn-sm btn-clean btn-icon user-delete" title="Delete"><i class="la la-trash"></i></a>' : '') .
                        (auth()->user()->hasPermissionTo('View Users') ? '<a href="' . route('admin.user.show', $user->id) . '" class="btn btn-sm btn-clean btn-icon" title="View details"><i class="la la-eye"></i></a>' : '')
                    ;
                })
                ->rawColumns(['action', 'status', 'phone'])
                ->make(true);
        }

        return view('admin.user.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create Users')) {
            abort(403);
        }
        if (Auth::guard('admin')->user()->id == 1) {

            $role = Role::where('guard_name', 'admin')->get()->pluck('name');
        } else {
            $role = Role::where('guard_name', 'admin')->where('created_by', Auth::guard('admin')->user()->id)->where('id', '!=', 1)->get()->pluck('name');

        }
        return view('admin.user.form')->with([
            'roles' => $role,
            'user_role' => '',
            'user' => new User(),
            'isd_codes' => Country::where('phone_prefix', '!=', null)->get(),
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
            'name' => 'required|string|max:255',
            //'proof' => 'required',

            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',

        ]);
        //dd($request->all());
        $request->request->add(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        $user->assignRole($request->role);
        if (!empty($request->file('proof'))) {

            $time = time();
            $filename = 'GROZ_' . $time;
            $media = MediaUploader::fromSource($request->file('proof'))
                ->useFilename($filename)
            // ->useHashForFilename()
            //->toDirectory('vendor')
                ->toDirectory('user_proof/' . $user->id)
                ->upload();

            $admin->attachMedia($media, ['proof']);
        }
        return redirect()->route('admin.user.index')->with('message', ' User Added Successfully..');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

        return view('admin.user.detail')->with([
            'user' => User::find($user->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit Users')) {
            abort(403);
        }
        if (Auth::guard('admin')->user()->id == 1) {

            $role = Role::where('guard_name', 'admin')->get()->pluck('name');
        } else {
            $role = Role::where('guard_name', 'admin')->where('created_by', Auth::guard('admin')->user()->id)->where('id', '!=', 1)->get()->pluck('name');

        }
        return view('admin.user.form')->with([
            'user' => User::find($user->id),
            'isd_codes' => Country::where('phone_prefix', '!=', null)->get(),
            'roles' => $role,
            'user_role' => $user->getRoleNames()->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|max:255',
            // 'gender_id' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id . ',id,deleted_at,NULL',
            'phone' => 'required|numeric|unique:users,phone,' . $user->id . ',id,deleted_at,NULL',

        ]);

        if ($request->get('password')) {
            $rules['password'] = 'required|min:8|confirmed';
            $rules['password_confirmation'] = 'required|same:password';

            $this->validate($request, $rules);
        }
        // if ($request->get('country_code')&& $request->get('state_code'))
        // {
        // $country= Country::where('iso_code_2', $request->country_code)->first();
        // $state= State::where('country_id', $country->id)->where('code', $request->state_code)->first();
        // $country_id=$country->id;
        // $state_id=$state->id;
        // }
        // else
        // {
        //  $country_id=$request->country_id;
        //  $state_id=$request->state_id;
        // }

        $user->fill($request->only(['name', 'last_name', 'email', 'notification_email', 'address', 'status', 'phone_prefix', 'phone']));

        if ($request->get('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        //$areaManager->country_id = $country_id;
        //$areaManager->state_id = $state_id;
        //dd($admin);
        //$customer->phone_prefix = trim($request->phone_prefix,"+");
        $user->status = $request->status;

        $user->save();

        if (!empty($request->file('proof'))) {
            $old_proof = Media::whereId($request->old_proof)->first();
            if ($old_proof) {
                $old_proof->delete();
            }
            $time = time();
            $filename = 'GROZ_' . $time;
            $media = MediaUploader::fromSource($request->file('proof'))
                ->useFilename($filename)
            // ->useHashForFilename()
            //->toDirectory('vendor')
                ->toDirectory('user_proof/' . $user->id)
                ->upload();

            $user->attachMedia($media, ['proof']);
        }
        if (!empty($request->input('role'))) {
            $user->syncRoles($request->input('role'));
        }
        return redirect()->route('admin.user.index')->with('message', ' User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete Users')) {
            abort(403);
        }
        $user->delete();
        return response()->json('success');
    }
}
