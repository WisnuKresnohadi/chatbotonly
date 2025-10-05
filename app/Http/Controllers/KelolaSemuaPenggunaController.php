<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaSemuaPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kelola_semua_pengguna.view');
    }

    public function index() {
        $roles = Role::all();

        return view('kelola_all_pengguna/index', compact('roles'));
    }

    public function getData(Request $request) {
        $user = User::all();

        return datatables()->of($user)
            ->addIndexColumn()
            ->editColumn('roles', fn ($data) => $data->getRoleNames()[0])
            ->addColumn('action', function ($data) {
                $btn = '<div class="d-flex justify-content-center">';
                $btn .= '<a class="cursor-pointer mx-1 text-warning" data-id="' .$data->id. '" onclick="edit($(this))"><i class="ti ti-edit"></i></a>';
                $btn .= '</div>';

                return $btn;
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }

    public function edit($id) {
        $user = User::select('id', 'name', 'email')->where('id', $id)->first();
        if (!$user) return Response::error(null, 'User not found!');
        $user->role = $user->roles->first()->uuid;
        unset($user->roles);

        return Response::success($user, 'Success!');
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            if (!$user) return Response::error(null, 'User not found!');

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $user->syncRoles($request->role);

            DB::commit();
            return Response::success(null, 'Update successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }
}
