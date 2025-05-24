<?php

namespace App\Http\Controllers\Application\Settings\Master\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.settings.master.roles.index');
    }

    public function getData()
    {
        $roles = Role::select(['id', 'display_name', 'name', 'disabled'])->where('id','!=',1);

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('check_box', function ($role) {
                return '<div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                        </div>';
            })
            ->addColumn('status', function ($role) {
                $checked = $role->disabled == 0 ? 'checked' : '';
                return '<div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input code-switcher enableBtn" type="checkbox" ' . $checked . '>
                    </div>';
            })
            ->addColumn('action', function ($role) {
                return '<div class="d-flex gap-2">
                            <div class="edit">
                                <button class="btn btn-sm btn-success edit-item-btn editBtn">Edit</button>
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-danger remove-item-btn removeBtn">Remove</button>
                            </div>
                        </div>';
            })
            ->rawColumns(['check_box', 'status', 'action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = $request->id ? Role::find($request->id) : new Role();
            $role->name = Str::slug($request->name);
            $role->display_name = $request->name;
            $role->guard_name = 'web';
            $role->disabled = $request->disabled?:0;
            $role->save();

            return response()->json(['message' => 'Role Saved.', 'code' => '200']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Some thing went wrong.', 'code' => '100']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return response()->json(['message' => 'Role Deleted.', 'code' => '200']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Some thing went wrong.', 'code' => '200']);
        }
    }
}
