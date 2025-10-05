<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Industri;
use App\Helpers\Response;
use App\Jobs\SendMailJob;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PegawaiIndustri;
use App\Http\Requests\CompanyReg;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Mail\RejectionNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\WriteAndReadCounterBadgeJob;
use Database\Seeders\EmailDefaultPerusahaanSeeder;

class KelolaMitraController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:kelola_mitra.view|kelola_mitra.approval', ['only' => ['index', 'edit', 'approved', 'rejected', 'statusKerjaSama']]);
        $this->middleware('permission:kelola_mitra.create', ['only' => ['store']]);

        $this->middleware(function ( $request, $next) {
            $response = $next($request);
            $data = $response->getOriginalContent();

            if ($response instanceof JsonResponse && $data['code'] == 200) {
                $result = new WriteAndReadCounterBadgeJob('kelola_mitra_count', 'decrement', function () {
                    return Industri::where('statusapprove', 0)->count();
                });
                $data['data'] = $result->get()->kelola_mitra_count;
                $response->setData($data);
            }

            return $response;
        })->only(['approved', 'rejected']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('company.kelola_mitra.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyReg $request)
    {
        try{
            DB::beginTransaction();
            $code = Str::random(64);

            $passwordResetToken = DB::table('password_reset_tokens')->where('email', $request->email)->first();
            if ($passwordResetToken) {
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            }

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $code,
                'created_at' => now(),
            ]);

            $admin = User::create([
                'name' => $request->namaindustri,
                'username' => $request->namaindustri,
                'email' => $request->email,
                'password' => Hash::make(Str::random(12)),
            ]);
            $admin->assignRole('Mitra');

            $industri = Industri::create([
                'namaindustri' => $request->namaindustri,
                'alamatindustri'=> $request->alamat,
                'description'=> $request->deskripsi,
                'kategori_industri' => $request->kategori_industri,
                'statuskerjasama' => $request->statuskerjasama,
                'statusapprove' => 1,
            ]);

            $administratorIndustri = PegawaiIndustri::create([
                'id_industri' => $industri->id_industri,
                'namapeg' => $request->penanggung_jawab,
                'nohppeg' => $request->contact_person,
                'emailpeg' => $request->email,
                'jabatan' => 'Administrator',
                'statuspeg' => true,
                'id_user' => $admin->id
            ]);

            $industri->penanggung_jawab = $administratorIndustri->id_peg_industri;
            $industri->save();

            $data['url'] = route('register.set-password', ['token' => $code]);
            $data['name'] = $admin->name;
            $data['message'] = 'Registrasi akun anda berhasil! Silakan atur password anda';
            dispatch(new SendMailJob($request->email, new VerifyEmail($data)));

            new EmailDefaultPerusahaanSeeder($industri);

            DB::commit();
            return Response::success(null, 'Industri successfully Created!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate(['status' => 'required|in:pending,verified,rejected']);
        $industri = Industri::with('penanggungJawab');
        $status = $request->status;

        if ($status == 'pending') $industri->where('statusapprove', 0);
        elseif ($status == 'verified') $industri->where('statusapprove', 1);
        elseif ($status == 'rejected') $industri->where('statusapprove', 2);

        return DataTables::of($industri->get())
            ->addIndexColumn()
            ->addColumn('aksi', function ($id) use ($status) {
                $btn = "<div class='d-flex justify-content-center'>";
                if ($status == 'pending') {
                    $btn .= "<a onclick='approved($(this))' class='mx-1 cursor-pointer text-success' data-id='{$id->id_industri}'><i class='ti ti-file-check' data-bs-toggle='tooltip' title='Approve'></i></a>";
                    $btn .= "<a onclick='rejected($(this))' class='mx-1 cursor-pointer text-danger' data-id='{$id->id_industri}'><i class='ti ti-file-x' data-bs-toggle='tooltip' title='Reject'></i></a>";
                }
                if ($status == 'verified') {
                    $btn .= '<a class="mx-1 cursor-pointer text-info" onclick="resetPassword($(this))" data-id="' .$id->id_industri. '"><i class="ti ti-mail-forward" data-bs-toggle="tooltip" title="Atur Ulang Passowrd Mitra"></i></a>';
                    $btn .= '<span class="mx-1 cursor-pointer text-warning" onclick="edit($(this))" data-id="' .$id->id_industri. '"><i class="ti ti-edit" data-bs-toggle="tooltip" title="Edit status kerja sama"></i></span>';
                }
                if ($status == 'rejected') {
                    $btn .= "<a onclick='deleteData($(this))' class='mx-1 cursor-pointer text-danger' data-id='{$id->id_industri}'><i class='ti ti-trash' data-bs-toggle='tooltip' title='Hapus'></i></a>";
                }
                $btn .= "</div>";

                return $btn;
            })
            ->editColumn('statuskerjasama', function ($row) {
                $badgeStyle = ($row->statuskerjasama == "Iya") ? ['color' => 'primary', 'text' => 'Iya'] : ['color' => 'danger', 'text' => 'Tidak'];
                return "<div class='text-center'><span class='badge rounded-pill bg-label-".$badgeStyle['color']."'>".$badgeStyle['text']."</span></div>";
            })
            ->editColumn('namaindustri', function ($data) {
                $x = '<div class="d-flex flex-column align-items-start">';
                $x .= '<span class="fw-bolder">' . $data->namaindustri . '</span>';
                $x .= '<small>' . $data->email . '</small>';
                $x .= '<small>' . $data->notelpon . '</small>';
                $x .= '</div>';
                return $x;
            })
            ->editColumn('penanggung_jawab', function ($data) {
                $data = $data->penanggungJawab;
                $x = '<div class="d-flex flex-column align-items-start">';
                $x .= '<span class="fw-bolder">' . $data->namapeg . '</span>';
                $x .= '<small>' . $data->emailpeg . '</small>';
                $x .= '<small>' . $data->nohppeg . '</small>';
                $x .= '</div>';
                return $x;
            })
            ->rawColumns(['aksi', 'namaindustri', 'penanggung_jawab', 'statuskerjasama'])
            ->make(true);
    }

    public function approved($id)
    {
        try {
            DB::beginTransaction();
            $industri = Industri::find($id);
            if (!$industri) return Response::error(null, 'Not Found.');
            if ($industri->statusapprove != 0) return Response::error(null, 'Mitra sudah diapprove.');
            $pegawaiIndustri = PegawaiIndustri::where('id_peg_industri', $industri->penanggung_jawab)->first();
            if (!$pegawaiIndustri) return Response::error(null, 'Not Found.');

            $industri->statusapprove = 1;
            $industri->save();

            $user = User::create([
                'name' => $pegawaiIndustri->namapeg,
                'username' => $pegawaiIndustri->namapeg,
                'email' => $pegawaiIndustri->emailpeg,
                'password' => Hash::make(Str::random(12)),
            ])->assignRole('Mitra');

            $pegawaiIndustri->update(['id_user' => $user->id]);

            $code = Str::random(60);

            $passwordResetToken = DB::table('password_reset_tokens')->where('email', $pegawaiIndustri->emailpeg)->first();

            if ($passwordResetToken) {
                DB::table('password_reset_tokens')->where('email', $pegawaiIndustri->emailpeg)->delete();
            }

            DB::table('password_reset_tokens')->insert([
                'email' => $pegawaiIndustri->emailpeg,
                'token' => $code,
                'created_at' => now(),
            ]);

            $data['url'] = route('register.set-password', ['token' => $code]);
            $data['name'] = $user->name;
            $data['message'] = 'Registrasi akun anda berhasil! Silakan atur password anda';

            dispatch(new SendMailJob($pegawaiIndustri->emailpeg, new VerifyEmail($data)));

            new EmailDefaultPerusahaanSeeder($industri);
            DB::commit();

            return Response::success(null, 'Persetujuan berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }
    public function rejected($id, Request $request)
    {
        $request->validate(['alasan' => 'required'], ['alasan.required' => 'Alasan wajib diisi.']);

        try {
            $data=Industri::join('pegawai_industri', 'industri.penanggung_jawab', '=', 'pegawai_industri.id_peg_industri')
            ->where('industri.id_industri', $id)->first();
            if (!$data) return Response::error(null, 'Industri Not Found.');
            $data->statusapprove='2';
            $data->save();
            $alasan = $request->input('alasan');

            $data['name'] = $data->namaindustri;
            $data['reason'] = $alasan;

            dispatch(new SendMailJob($data->emailpeg, new RejectionNotification($data)));
            return Response::success(null, 'Berhasil menolak.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }


    public function edit(string $id)
    {
        $industri = Industri::with('penanggungJawab')->where('id_industri', $id)->first();
        $industri->penanggung_jawab = $industri->penanggungJawab->namapeg;
        $industri->email = $industri->penanggungJawab->emailpeg;
        $industri->contact_person = $industri->penanggungJawab->nohppeg;

        unset($industri->penanggungJawab);
        return $industri;
    }

    public function update(CompanyReg $request, $id)
    {
        try {
            DB::beginTransaction();

            $industri = Industri::where('id_industri', $id)->first();
            if (!$industri) return Response::error(null, 'Not Found.');
            $penanggungJawab = PegawaiIndustri::where('id_peg_industri', $industri->penanggung_jawab)->first();
            $user = User::where('id', $penanggungJawab->id_user)->first();


            $user->name = $request->namaindustri;
            $user->username = $request->namaindustri;
            $user->email = $request->email;
            $user->save();

            $industri->namaindustri = $request->namaindustri;
            $industri->alamatindustri = $request->alamat;
            $industri->description = $request->deskripsi;
            $industri->kategori_industri = $request->kategori_industri;
            $industri->statuskerjasama = $request->statuskerjasama;
            $industri->save();

            $penanggungJawab->namapeg = $request->penanggung_jawab;
            $penanggungJawab->nohppeg = $request->contact_person;
            $penanggungJawab->emailpeg = $request->email;
            $penanggungJawab->save();

            DB::commit();
            return Response::success(null, 'Data Successfully Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function status($id)
    {
        try {
            $industri = Industri::where('id_industri', $id)->first();
            $industri->status = ($industri->status) ? false : true;
            $industri->save();

            return response()->json([
                'error' => false,
                'message' => 'Status successfully Updated!',
                'table' => '#table-kelola-mitra3'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function statusKerjaSama(Request $request, $id) {
        try {
            $validateReq = ['statuskerjasama' => 'required|in:Iya,Tidak'];
            $validateMsg = [
                'statuskerjasama.required' => 'Pilih status kerja sama',
                'statuskerjasama.in' => 'Status tidak valid'
            ];
            $request->validate($validateReq, $validateMsg);
            $industri = Industri::where('id_industri', $id)->first();
            if (!$industri) return Response::error(null, 'Not Found.');
            $industri->statuskerjasama = $request->statuskerjasama;
            $industri->save();

            return Response::success(null, 'Status successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function delete($id)
    {
        try {
            $industri = Industri::where('id_industri', $id)->where('statusapprove', 2)->first();
            if (!$industri) return Response::error(null, 'Not Found.');
            $pegawai = PegawaiIndustri::where('id_peg_industri', $industri->penanggung_jawab)->first();
            $industri->penanggung_jawab = null;
            $industri->save();
            $pegawai->delete();
            $industri->delete();
            return Response::success(null, 'Data berhasil dihapus.');
        } catch (\Exception $th) {
            return Response::errorCatch($th);
        }
    }

    public function resetPassword($id) {
        try {
            $industri = Industri::where('id_industri', $id)->where('statusapprove', 1)->first();
            if (!$industri) return Response::error(null, 'Mitra not found!');
            $penanggungJawab = $industri->penanggungJawab;

            $passwordResetToken = DB::table('password_reset_tokens')->where('email', $penanggungJawab->emailpeg)->first();
            if ($passwordResetToken) {
                DB::table('password_reset_tokens')->where('email', $penanggungJawab->emailpeg)->delete();
            }

            $code = Str::random(60);
            DB::table('password_reset_tokens')->insert([
                'email' => $penanggungJawab->emailpeg,
                'token' => $code,
                'created_at' => now(),
            ]);

            $data['url'] = route('register.set-password', ['token' => $code]);
            $data['name'] = $penanggungJawab->namapeg;
            $data['message'] = 'Reset password akun anda berhasil! Silakan atur password anda';
            dispatch(new SendMailJob($penanggungJawab->emailpeg, new VerifyEmail($data)));

            return Response::success(null, 'Password reset link has been sent!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

}
