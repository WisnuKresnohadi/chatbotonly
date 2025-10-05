<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Dosen;
use App\Helpers\Response;
use App\Jobs\SendMailJob;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaPenggunaController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $roles = Role::whereIn('name', ['LKM', 'Dosen', 'Kaprodi', "Koordinator Magang"])->get();
        return view('admin.kelola-pengguna.index', compact('roles'));
    }

    public function getData(Request $request) {
        $roles = ['LKM', 'Kaprodi', 'Dosen', 'Koordinator Magang'];
        $user = User::with('roles')->whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->get();

        return datatables()->of($user)
        ->addIndexColumn()
        ->editColumn('roles', function ($data) {
            return '<div class="text-center">' .$data->roles[0]->name. '</div>';
        })
        ->addColumn('status', function ($data) {
            $result = '<div class="d-flex justify-content-center">';
            if ($data->hasRole('LKM') || ($data->dosen?->status ?? false)) {
                $result .= '<span class="badge rounded-pill bg-label-success">Active</span>';
            } else {
                $result .= '<span class="badge rounded-pill bg-label-danger">Inactive</span>';
            }
            $result .= '</div>';

            return $result;
        })
        ->addColumn('action', function ($data) {
            $icon = (isset($data->dosen) && $data->dosen->status) ? "ti-circle-x" : "ti-circle-check";
            $color = (isset($data->dosen) && $data->dosen->status) ? "danger" : "primary";

            $url = route('kelola_pengguna.update_status', $data->id);

            $result = '<div class="d-flex justify-content-center">';
            $result .= '<a class="mx-1 cursor-pointer text-warning" onclick="edit($(this))" data-id="' .$data->id. '"><i class="ti ti-edit"></i></a>';
            $result .= '<a class="mx-1 cursor-pointer text-info" onclick="resetPassword($(this))" data-id="' .$data->id. '"><i class="ti ti-mail-forward"></i></a>';
            if (!$data->hasRole('LKM')) {
                $result .= '<a class="mx-1 cursor-pointer update-status text-'.$color.'" data-url="'.$url.'" data-function="afterUpdateStatus" data-id="' .$data->id. '"><i class="ti ' .$icon. '"></i></a>';
            }
            $result .= '</div>';
            return $result;
        })
        ->rawColumns(['roles', 'status', 'action'])
        ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email'
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.'
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'username' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(12)),
            ])->assignRole('LKM');

            $code = Str::random(60);
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $code,
                'created_at' => now(),
            ]);

            $data['url'] = route('register.set-password', ['token' => $code]);
            $data['name'] = $user->name;
            $data['message'] = 'Pendaftaran akun anda berhasil! Silakan atur password anda';
            dispatch(new SendMailJob($request->email, new VerifyEmail($data)));

            DB::commit();
            return Response::success(null, 'LKM successfully created! Please check his/her email for verification.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }


    public function edit($id) {
        $user = User::where('id', $id)->first();
        if (!$user) return Response::error(null, 'User not found!');
        $user->role = $user->roles->first()->name;
        return Response::success($user, 'Success');
    }

    public function update(Request $request, $id) {

        $validate = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'role' => 'required|in:Dosen,Kaprodi,Koordinator Magang'
        ];

        $user = User::where('id', $id)->first();
        if (!$user) return Response::error(null, 'User not found!');
        if ($user->hasRole('LKM')) unset($validate['role']);

        $request->validate($validate, [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Role harus diisi.',
            'role.in' => 'Role tidak valid.'
        ]);

        try {
            DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            if ($user->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang'])) {
                $user->dosen()->update([
                    'namadosen' => $request->name,
                    'emaildosen' => $request->email
                ]);
                $user->syncRoles([$request->role]);
            }

            DB::commit();
            return Response::success(null, 'User successfully updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function updateStatus($id) {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) return Response::error(null, 'User not found!');
            if (!$user->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang'])) return Response::error(null, 'User not found!');

            $dosen = Dosen::where('id_user', $user->id)->first();

            $dosen->status = !$dosen->status;
            $dosen->save();

            return Response::success(null, 'Status successfully changed!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function resetPassword($id) {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) return Response::error(null, 'User not found!');

            $passwordResetToken = DB::table('password_reset_tokens')->where('email', $user->email)->first();
            if ($passwordResetToken) {
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            }

            $code = Str::random(60);
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $code,
                'created_at' => now(),
            ]);

            $data['url'] = route('register.set-password', ['token' => $code]);
            $data['name'] = $user->name;
            $data['message'] = 'Reset password akun anda berhasil! Silakan atur password anda';
            dispatch(new SendMailJob($user->email, new VerifyEmail($data)));

            return Response::success(null, 'Password reset link has been sent!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
