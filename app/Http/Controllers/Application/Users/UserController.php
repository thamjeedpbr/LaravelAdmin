<?php

namespace App\Http\Controllers\Application\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.users.index');
    }

    public function getData()
    {
        $users = User::select(['id', 'name', 'email', 'phone', 'no_of_client',
            'valid_till', 'disabled'])->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super-admin');
        });

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('check_box', function ($item) {
                return '<div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                        </div>';
            })
            ->addColumn('role', function ($item) {

                return $item->getRoleNames()[0];
            })
            ->addColumn('status', function ($item) {
                $checked = $item->disabled == 0 ? 'checked' : '';
                return '<div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input code-switcher enableBtn" type="checkbox" ' . $checked . '>
                    </div>';
            })
            ->addColumn('action', function ($item) {
                return '<div class="d-flex gap-2">
                            <div class="edit">
                                <a href="users/' . $item->id . '/edit"
                                <button class="btn btn-sm btn-success edit-item-btn editBtn">Edit</button>
                                </a>
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-danger remove-item-btn removeBtn">Remove</button>
                            </div>
                        </div>';
            })
            ->rawColumns(['check_box', 'status', 'action', 'role'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('application.users.create')->with([
            'roles' => Role::whereNotIn('name', ['super-admin'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->email;
            $user->phone = $request->phone;
            $user->type = "user";
            $user->no_of_client = $request->no_of_client;
            $user->valid_till = $request->valid_till;
            $user->token = User::generateUniqueRandomString();
            // $user->institute_id = GlobalHelper::getInstitute();
            $user->password = $request->password;
            $user->avatar = 'user-icon.webp';
            if ($user->save()) {
                $user->assignRole($request->role);
                return response()->json(['message' => 'User Created.', 'code' => '200']);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'code' => '100']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('application.users.edit')->with([
            'roles' => Role::whereNotIn('name', ['super-admin', 'teacher', 'student'])->get(),
            'editable' => User::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->email;
            $user->phone = $request->phone;
            if ($request->password) {
                $user->password = $request->password;
            }
            $user->no_of_client = $request->no_of_client;
            $user->valid_till = $request->valid_till;
            $user->update();
            $user->assignRole($request->role);
            return response()->json(['message' => 'User Updated.', 'code' => '200']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'code' => '100']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->disabled = $user->disabled == 0 ? 1 : 0;
            $user->save();
            return response()->json(['message' => 'User status changed.', 'code' => '200']);
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
        //
    }
}
