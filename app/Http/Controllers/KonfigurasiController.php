<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleHas;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KonfigurasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:roles.view');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $permissions = Permission::get();
        $role = Role::latest()->get();
        return view('konfigurasi.konfigurasi', compact('role', 'permissions'));
    }

    public function show(Request $id)
    {
        $role = Role::orderBy('name', 'asc')
            ->get();
            return DataTables::of($role)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return "<div class='text-center'><a data-id='{$row->uuid}' onclick=edit($(this)) class='cursor-pointer text-warning'><i class='tf-icons ti ti-edit' ></i></div>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'name' => 'required|max:191|unique:roles'
            ]);
    
            if ($validatedData->fails()) {
                return Response::errorValidate($validatedData->errors(), 'Failed to Add Role!');
            }
    
            $result = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ])->syncPermissions($request->permission_id);
    
            Artisan::call('cache:clear');

            return Response::success(null, "Role added successfully!");
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function edit($id) {
        $role = Role::findById($id);
        if (!$role) return Response::error(null, "Role not found!");
        $permissions = $role->permissions->pluck('uuid');

        return Response::success([
            "role" => $role->name,
            "permissions" => $permissions
        ], "Role found!");
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|max:191|unique:roles,name,' . $id . ',uuid',
        ]);

        try {
            $role = Role::findById($id);
            if (!$role) return Response::error(null, "Role not found!");
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permission_id);

            Artisan::call('cache:clear');

            return Response::success(null, "Role updated successfully!");
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
