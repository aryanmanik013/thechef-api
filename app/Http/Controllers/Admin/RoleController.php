<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
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
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('View UserRoles')) {
            abort(403);
        }
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->id == 1) {
                $query = Role::where('id', '!=', 1)->where('guard_name', 'admin')->select('roles.*');

            } else {
                $query = Role::where('created_by', Auth::guard('admin')->user()->id)->where('id', '!=', 1)->where('guard_name', 'admin')->select('roles.*');
            }

            return $datatables->eloquent($query)
                ->addColumn('action', function (Role $role) {
                    return (auth()->user()->hasPermissionTo('Edit UserRoles') ? '<a href="' . route('admin.role.edit', $role->id) . '"  class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
              ' : '');

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.role.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Create UserRoles')) {
            abort(403);
        }
        return view('admin.role.form')->with([
            'role' => new Role(),
            'permissions' => Permission::where('guard_name', 'admin')->get(),
            'role_permissions' => [],
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
        ]);
        $role = Role::create(['name' => $request->input('name'), 'created_by' => Auth::guard('admin')->user()->id]);
        $role->givePermissionTo($request->input('permission', []));

        $request->session()->flash('success', 'Role created successfully');
        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Edit UserRoles')) {
            abort(403);
        }
        return view('admin.role.form')->with([
            'role' => $role,
            'permissions' => Permission::where('guard_name', 'admin')->get(),
            'role_permissions' => $role->permissions()->get()->pluck('name')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $role->update(['name' => $request->input('name'), 'created_by' => Auth::guard('admin')->user()->id]);
        $role->syncPermissions($request->input('permission', []));
        $request->session()->flash('success', 'Role updated successfully');
        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (Auth::guard('admin')->user()->id != 1 && !auth()->user()->hasPermissionTo('Delete UserRoles')) {
            abort(403);
        }
        $role->delete();
        $request->session()->flash('success', 'Role deleted successfully');
        return redirect()->route('admin.role.index');
    }
}
