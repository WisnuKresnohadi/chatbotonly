<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Helpers\Response;
use App\Models\Mahasiswa;
use App\Models\MhsMagang;
use App\Models\Universitas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\PegawaiIndustri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Super Admin|LKM|Mitra|Dosen|Kaprodi|Pembimbing Lapangan|Koordinator Magang']);
    }

    public function index(Request $request)
    {
        $data['user'] = auth()->user();
        if ($data['user']->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang'])) {
            $data['dosen'] = Dosen::select('universitas.namauniv', 'fakultas.namafakultas', 'program_studi.namaprodi', 'dosen.*')
                ->join('universitas', 'universitas.id_univ', '=', 'dosen.id_univ')
                ->join('fakultas', 'fakultas.id_fakultas', '=', 'dosen.id_fakultas')
                ->join('program_studi', 'program_studi.id_prodi', '=', 'dosen.id_prodi')
                ->where('id_user', $data['user']->id)->first();
            if ($request->ajax()) {
                switch ($request->type) {
                    case 'id_fakultas':
                        $data = Fakultas::select('namafakultas as text', 'id_fakultas as id')->where('id_univ', $request->selected)->get();
                        break;
                    case 'id_prodi':
                        $data = ProgramStudi::select('namaprodi as text', 'id_prodi as id')->where('id_fakultas', $request->selected)->get();
                        break;
                    case 'kode_dosen':
                        $data = Dosen::where('id_prodi', $request->selected)->get()->transform(function ($item) {
                            $result = new \stdClass();
                            $result->text = $item->kode_dosen . ' | ' . $item->namadosen;
                            $result->id = $item->kode_dosen;
                            return $result;
                        });
                        break;
                    default:
                        # code...
                        break;
                }
                return Response::success($data, 'Success');
            }
            $data['universitas'] = Universitas::all();
            $data['title'] = 'Profile Dosen';
        } else if ($data['user']->hasAnyRole(['Mitra', 'Pembimbing Lapangan'])) {
            $data['pegawai'] = PegawaiIndustri::select('namapeg', 'nohppeg', 'emailpeg', 'jabatan')
                ->where('id_user', $data['user']->id)->first();
            $data['title'] = 'Profile Mitra';
        } else if ($data['user']->hasAnyRole(['LKM', 'Super Admin'])) {
            $data['title'] = 'Profile LKM';
        }

        return view('profile.detail-profile.index', $data);
    }

    public function show(Request $request)
    {
        try {

            $user = auth()->user();
            $data = null;

            if ($user->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang'])) {
                $data = Dosen::select(
                    'universitas.namauniv as id_univ',
                    'fakultas.namafakultas as id_fakultas',
                    'program_studi.namaprodi as id_prodi',
                    'dosen.namadosen as name',
                    'dosen.nohpdosen as nohp',
                    'dosen.emaildosen as email',
                    'dosen.nip',
                    'dosen.kode_dosen'
                )
                    ->join('universitas', 'universitas.id_univ', 'dosen.id_univ')
                    ->join('fakultas', 'fakultas.id_fakultas', 'dosen.id_fakultas')
                    ->join('program_studi', 'program_studi.id_prodi', 'dosen.id_prodi')
                    ->where('dosen.id_user', $user->id)->first();
            } else if ($user->hasAnyRole(['Mitra', 'Pembimbing Lapangan'])) {
                $data = PegawaiIndustri::select(
                    'namapeg as name',
                    'nohppeg as nohp',
                    'emailpeg as email',
                    'jabatan'
                )->where('id_user', $user->id)->first();
            } else if ($user->hasAnyRole(['Super Admin', 'LKM'])) {
                $data = [
                    'email' => $user->email,
                    'name' => $user->name
                ];
            }

            return Response::success($data, 'Success');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateData(Request $request)
    {
        try {
            $user = auth()->user();

            $validate = ['name' => ['required']];

            if ($user->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang'])) {
                $validate['email'] = [
                    'required',
                    'email',
                    'unique:users,email,' . $user->id,
                    'unique:dosen,emaildosen,' . $user->id . ',id_user',
                    'unique:mahasiswa,emailmhs',
                    'unique:pegawai_industri,emailpeg'
                ];

                $validate['nohp'] = ['required', 'numeric'];
                $validate['nip'] = [
                    'required',
                    'numeric',
                    'unique:dosen,nip,' . $user->id . ',id_user'
                ];
                $validate['kode_dosen'] = [
                    'required',
                    'unique:dosen,kode_dosen,' . $user->id . ',id_user'
                ];
            } else if ($user->hasAnyRole(['Mitra', 'Pembimbing Lapangan'])) {
                $validate['email'] = [
                    'required',
                    'email',
                    'unique:users,email,' . $user->id,
                    'unique:pegawai_industri,emailpeg,' . $user->id . ',id_user',
                    'unique:dosen,emaildosen',
                    'unique:mahasiswa,emailmhs'
                ];

                $validate['nohp'] = ['required', 'numeric'];
            } else if ($user->hasAnyRole(['Super Admin', 'LKM'])) {
                $validate['email'] = [
                    'required',
                    'email',
                    'unique:users,email,' . $user->id,
                    'unique:pegawai_industri,emailpeg',
                    'unique:dosen,emaildosen',
                    'unique:mahasiswa,emailmhs'
                ];
            }

            $validator = Validator::make($request->all(), $validate, [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'name.required' => 'Nama harus diisi',
                'nohp.required' => 'No. HP harus diisi',
                'nohp.numeric' => 'No. HP harus angka',
                'nip.required' => 'NIP harus diisi',
                'nip.numeric' => 'NIP harus angka',
                'nip.unique' => 'NIP sudah terdaftar',
                'kode_dosen.required' => 'Kode Dosen harus diisi',
                'kode_dosen.unique' => 'Kode Dosen sudah terdaftar'
            ]);

            if ($validator->fails()) {
                return Response::errorValidate($validator->errors());
            }

            DB::beginTransaction();

            $user->email = $request->email;
            $user->name = $request->name;

            $data = [];

            if ($user->hasAnyRole(['Dosen', 'Kaprodi', 'Koordinator Magang'])) {
                $dosen = Dosen::select(
                    'universitas.namauniv',
                    'fakultas.namafakultas',
                    'program_studi.namaprodi',
                    'dosen.namadosen',
                    'dosen.nohpdosen',
                    'dosen.emaildosen',
                    'dosen.nip',
                    'dosen.kode_dosen'
                )
                ->join('universitas', 'universitas.id_univ', 'dosen.id_univ')
                ->join('fakultas', 'fakultas.id_fakultas', 'dosen.id_fakultas')
                ->join('program_studi', 'program_studi.id_prodi', 'dosen.id_prodi')
                ->where('dosen.id_user', $user->id)->first();

                $dosen->emaildosen = $request->email;
                $dosen->namadosen = $request->name;
                $dosen->nohpdosen = $request->nohp;
                $dosen->nip = $request->nip;
                $dosen->kode_dosen = $request->kode_dosen;
                $dosen->save();

                $data['dosen'] = $dosen;
            } else if ($user->hasAnyRole(['Mitra', 'Pembimbing Lapangan'])) {
                $pegawai_industri = $user->pegawai_industri;
                $pegawai_industri->emailpeg = $request->email;
                $pegawai_industri->namapeg = $request->name;
                $pegawai_industri->nohppeg = $request->nohp;
                $pegawai_industri->save();

                $data['pegawai'] = $pegawai_industri;
            }

            $user->save();

            DB::commit();
            return Response::success([
                'view' => view('profile/detail-profile/components/card_detail', $data)->render()
            ], 'Berhasil memperbarui data.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function gantiFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|mimes:jpeg,jpg,png',
        ], [
            'foto.required' => 'Foto Wajib',
            'foto.mimes' => 'Foto di perbolehkan hanya jpg,jpeg,png',
        ]);

        try {
            $user = auth()->user();
            $file = null;
            if ($request->hasFile('foto')) {
                if ($user->foto && Storage::has($user->foto)) {
                    Storage::delete($user);
                }
                $file = Storage::put('foto', $request->file('foto'));
            }
            $user->foto = $file;
            $user->save();
            Response::success(null, 'Update Foto Profil Berhasil');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function deleteFoto()
    {
        try {
            $user = auth()->user();
            if ($user->foto) {
                Storage::delete($user->foto);
                $user->foto = null;
                $user->save();
            }

            return Response::success(null, 'Foto berhasil dihapus.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed'],
            'new_password_confirmation' => ['required']
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.confirmed' => 'Tidak cocok dengan konfirmasi password.',
            'new_password_confirmation.required' => 'Konfirmasi password baru wajib diisi.',
            'new_password_confirmation.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            return Response::success(null, 'Berhasil mengganti password.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
